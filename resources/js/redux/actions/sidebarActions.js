export const TOGGLE_SIDEBAR = 'TOGGLE_SIDEBAR';
export const TOGGLE_MOBILE_SIDEBAR = 'TOGGLE_MOBILE_SIDEBAR';

export function toggleSidebar() {
  return {
    type: TOGGLE_SIDEBAR,
  };
}
export function toggleMobileSidebar() {
  return {
    type: TOGGLE_MOBILE_SIDEBAR,
  };
}