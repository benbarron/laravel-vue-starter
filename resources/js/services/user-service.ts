import axios, { AxiosResponse } from 'axios';
import { CreateUserDTO, UpdateUserDTO } from '../@types/user';

export default class UserService {
  public async getLoggedInUser<T = any>(): Promise<T> {
    const response: AxiosResponse<T> = await axios.get('/api/user');
    return response.data;
  }

  public async getAllUsers<T = any>(): Promise<T> {
    const response: AxiosResponse<T> = await axios.get('/api/users');
    return response.data;
  }

  public async getUserById<T = any>(id: string): Promise<T> {
    const response: AxiosResponse<T> = await axios.get(`/api/users/${id}`);
    return response.data;
  }

  public async updateUser<T = any>(id: string, payload: UpdateUserDTO): Promise<T> {
    try {
      const response: AxiosResponse<T> = await axios.put(`/api/users/${id}`, payload);
      return response.data;
    } catch (err) {
      throw new Error(err.response.data.message);
    }
  }

  public async createUser<T = any>(payload: CreateUserDTO): Promise<T> {
    try {
      const response: AxiosResponse<T> = await axios.post('/api/users', payload);
      return response.data;
    } catch (err) {
      throw new Error(err.response.data.message);
    }
  }
}
