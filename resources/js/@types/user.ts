export interface CreateUserDTO {
  name: string;
  email: string;
  password: string;
  role: number;
}

export interface UpdateUserDTO {
  name: string;
  email: string;
  role: number;
}
