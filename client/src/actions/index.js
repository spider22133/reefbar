import axios from 'axios';

export const FETCH_MENU = 'FETCH_MENU';

const API_ROOT = process.env.REACT_APP_API_URL;
const MENU_ENDPOINT = `${API_ROOT}/wp-json/react-theme/v1/menu-locations/`;


console.log(MENU_ENDPOINT);

export function fetchMenu(menu) {
    return function (dispatch) {
        axios.get(`${MENU_ENDPOINT}${menu}`)
            .then(response => {
                console.log(response);
                dispatch({
                    type: FETCH_MENU,
                    payload: {items: response.data, name: menu}
                });
            });
    }
}

// export function fetchMenu() {
//     return function action(dispatch) {
//         dispatch({ type: FETCH_MENU })
//
//         const request = axios.get(`${MENU_ENDPOINT}${menu}`);
//
//         return request.then(
//             response => dispatch(fetchOffersSuccess(response)),
//             err => dispatch(fetchOffersError(err))
//         );
//     }
// }