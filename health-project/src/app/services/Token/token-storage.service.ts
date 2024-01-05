import { Injectable } from '@angular/core';

const TOKEN_KEY = 'auth-token';
const USER_KEY = 'auth-user';

@Injectable({
  providedIn: 'root',
})
export class TokenStorageService {
  constructor() {}

  signOut(): void {
    localStorage.clear();
  }

  public getToken(): string | null {
    return localStorage.getItem(TOKEN_KEY);
  }
  public saveToken(token: string): void {
    localStorage.removeItem(TOKEN_KEY);
    localStorage.setItem(TOKEN_KEY, token);
  }

  public getUser(): any {
    const user = localStorage.getItem(USER_KEY);
    if (user) {
      return JSON.parse(user);
    }

    return {};
  }
  public saveUser(user: any): void {
    localStorage.removeItem(USER_KEY);
    localStorage.setItem(USER_KEY, JSON.stringify(user));
  }

  public getSession(key: any): string | null {
    return localStorage.getItem(key);
  }
  public setSession(key: any, value: any): void {
    localStorage.removeItem(key);
    localStorage.setItem(key, value);
  }
  public removeSession(key: any) {
    localStorage.removeItem(key);
  }
}
