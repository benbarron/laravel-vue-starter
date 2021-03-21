<template>
  <div>
    <v-row justify="space-around" class="control-menu">
      <v-icon color="red" @click="hangUp" class="hangup-icon"> mdi-exit-to-app </v-icon>
      <v-icon v-if="isVolumeOn" color="white" @click="toggleVolume"> mdi-volume-high </v-icon>
      <v-icon v-else color="white" @click="toggleVolume"> mdi-volume-off</v-icon>
      <v-icon v-if="isVideoOn" color="white" @click="toggleVideo">mdi-video-box</v-icon>
      <v-icon v-else color="white" @click="toggleVideo"> mdi-video-box-off</v-icon>
    </v-row>
    <div class="row m-0 p-0">
      <div class="col-sm-6 m-0 p-0">
        <video
          id="localVideo"
          class="video-stream"
          v-if="isVideoOn"
          :srcObject.prop="localStream"
          autoplay="autoplay"
        ></video>
        <div v-else class="video-stream">
          <h5>{{ user.name }}</h5>
        </div>
      </div>
      <div class="col-sm-6 m-0 p-0">
        <video
          id="remoteVideo"
          class="video-stream"
          :srcObject.prop="remoteStream"
          autoplay="autoplay"
        ></video>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import store from './../store';
import firebase from 'firebase';
import config from './../config';

@Component
export default class Meeting extends Vue {
  private localStream: MediaStream | null = null;
  private remoteStream: MediaStream | null = null;
  private peerConnection: RTCPeerConnection = new RTCPeerConnection(config.ice);
  private roomId: string = '';

  private isVolumeOn: boolean = true;
  private isVideoOn: boolean = true;

  private db: firebase.firestore.Firestore;

  async openUserMedia() {
    if (this.isVolumeOn || this.isVideoOn) {
      this.localStream = await navigator.mediaDevices.getUserMedia({
        video: this.isVideoOn,
        audio: this.isVolumeOn,
      });
      this.localStream?.getTracks().forEach((track) => {
        if (this.localStream) {
          this.peerConnection?.addTrack(track, this.localStream);
        }
      });
    } else {
      this.localStream?.getTracks().forEach((t) => t.stop());
      this.localStream = null;
    }
  }

  mounted() {
    store.commit('setBreadcrumbs', []);
    this.db = firebase.firestore();
    this.peerConnection = new RTCPeerConnection(config.ice);
    this.remoteStream = new MediaStream();

    this.peerConnection.ontrack = (event) => {
      event.streams[0].getTracks().forEach((track) => {
        this.remoteStream?.addTrack(track);
      });
    };

    this.openUserMedia().then(() => {
      if (this.$route.query.j === 'f') {
        this.createRoom();
      } else {
        this.joinRoom();
      }
    });
  }

  toggleVideo() {
    this.isVideoOn = !this.isVideoOn;
    this.openUserMedia();
  }

  toggleVolume() {
    this.isVolumeOn = !this.isVolumeOn;
    this.openUserMedia();
  }

  hangUp() {
    this.localStream?.getTracks().forEach((t) => t.stop());
    this.remoteStream?.getTracks().forEach((t) => t.stop());
    this.peerConnection?.close();
    this.db.collection('calls').doc(this.roomId).delete();
    window.location.href = '/home';
  }

  get user() {
    return store.getters.getUser;
  }

  async createRoom() {
    this.roomId = this.$route.query.id as string;
    const call = await this.db.collection('calls').doc(this.roomId);
    const offerCandidates = call.collection('offerCandidates');
    const answerCandidates = call.collection('answerCandidates');

    this.peerConnection.onicecandidate = (event) => {
      event.candidate && offerCandidates.add(event.candidate.toJSON());
    };

    const offerDescription = await this.peerConnection.createOffer();
    await this.peerConnection.setLocalDescription(offerDescription);
    await call.set({ offer: { type: offerDescription.type, sdp: offerDescription.sdp } });

    call.onSnapshot((snapshot) => {
      const data = snapshot.data();
      if (!this.peerConnection.currentRemoteDescription && data?.answer) {
        const answerDescription = new RTCSessionDescription(data.answer);
        this.peerConnection.setRemoteDescription(answerDescription);
      }
    });

    this.listenForCallEnd(call.id);

    this.peerConnection.addEventListener('track', (event: RTCTrackEvent) => {
      console.log('Got remote track:', event.streams[0]);
      event.streams[0].getTracks().forEach((track: MediaStreamTrack) => {
        console.log('Add a track to the remoteStream:', track);
        this.remoteStream?.addTrack(track);
      });
    });

    answerCandidates.onSnapshot((snapshot) => {
      snapshot.docChanges().forEach((change) => {
        if (change.type === 'added') {
          const candidate = new RTCIceCandidate(change.doc.data());
          this.peerConnection.addIceCandidate(candidate);
        }
      });
    });
  }

  async joinRoom() {
    this.roomId = this.$route.query.id as string;
    const callDoc = this.db.collection('calls').doc(this.roomId);
    const answerCandidates = callDoc.collection('answerCandidates');
    const offerCandidates = callDoc.collection('offerCandidates');

    this.peerConnection.onicecandidate = (event) => {
      event.candidate && answerCandidates.add(event.candidate.toJSON());
    };

    const callData = (await callDoc.get()).data();
    const offerDescription = callData?.offer;
    const rtcSessDescription = new RTCSessionDescription(offerDescription);
    await this.peerConnection.setRemoteDescription(rtcSessDescription);
    const answerDescription = await this.peerConnection.createAnswer();
    await this.peerConnection.setLocalDescription(answerDescription);

    const answer = {
      type: answerDescription.type,
      sdp: answerDescription.sdp,
    };

    await callDoc.update({ answer });

    this.listenForCallEnd(callDoc.id);

    offerCandidates.onSnapshot((snapshot) => {
      snapshot.docChanges().forEach((change) => {
        console.log(change);
        if (change.type === 'added') {
          let data = change.doc.data();
          this.peerConnection.addIceCandidate(new RTCIceCandidate(data));
        }
      });
    });
  }

  public listenForCallEnd(id: string) {
    this.db
      .collection('calls')
      .where(firebase.firestore.FieldPath.documentId(), '==', id)
      .onSnapshot((snapshot) => {
        console.log(snapshot);
        snapshot.docChanges().forEach((change) => {
          if (change.type === 'removed') {
            this.$router.push('/home');
            store.commit('setSnackbar', {
              color: 'info',
              message: 'Call has been ended.',
              timeout: 5000,
              show: true,
            });
          }
        });
      });
  }
}
</script>

<style scoped>
.video-stream {
  width: 100%;
  height: 300px;
  border: #333 2px solid;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
}
.control-menu {
  margin: 0 !important;
  display: flex;
  align-items: center;
  border-bottom: #333 2px solid;
  height: 50px;
}
.hangup-icon {
  transform: rotate(180deg);
}
</style>
