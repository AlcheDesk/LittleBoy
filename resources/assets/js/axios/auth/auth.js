import { apiGet, apiPost, apiPatch, apiDelete, apiPut } from '../index'

export function login(param) {
  return apiPost('/api/auth/login/', param);
}

export function register(param) {
  return apiPost('/api/auth/signup/', param);
}