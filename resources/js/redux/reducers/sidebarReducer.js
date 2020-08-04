import { TOGGLE_SIDEBAR, TOGGLE_MOBILE_SIDEBAR } from "../actions/sidebarActions";

const initialState = {
    isSidebarOpened: false,
    isMobileSidebarOpened: false
  };

export default function (state = initialState, action) {
    switch (action.type) {
      case TOGGLE_SIDEBAR:
        return { ...state, isSidebarOpened: !state.isSidebarOpened };
      case TOGGLE_MOBILE_SIDEBAR:
        return { ...state, isMobileSidebarOpened: !state.isMobileSidebarOpened };
      default: {
        return state;
      }
    }
  }