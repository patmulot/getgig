import axios from 'axios';
import storage from '../plugins/storage.js';
const userService = {
  // setting base URIs :
  //! ---------------------------------------------------------------------------
  //! WARNING FOR THE LOCAL BASE URI , USE YOUR OWN "localhost" url :
  baseURI: "http://localhost/neo/my-projects/getgig/getgig-back/public/index.php",
//  baseURI: "http://localhost/neo/getgig/projet-get-gig/public/index.php",


  //! ---------------------------------------------------------------------------
  // enpoints URI :
  wpApiRestAddURI: "/wp-json/wp/v2",
  customEndPointURI: "/wp-json/getgigwp/v1",
  jwtApiURI: "/wp-json/jwt-auth/v1",
  register: async function (userNameFromForm, userPasswordFromForm, userEmailFromForm, userRoleFromForm, userLocationFromForm) {
    const result = await axios.post(
        userService.baseURI + userService.customEndPointURI + '/register', {
          username: userNameFromForm,
          password: userPasswordFromForm,
          email: userEmailFromForm,
          role: userRoleFromForm,
          location: userLocationFromForm,
        }
      )
      .catch(function () {
        return false;
      });
    return result;
  },
  login: async function (login, password) {
    let response = await axios.post(
      userService.baseURI + userService.jwtApiURI + '/token', {
        username: login,
        password: password
      }
    ).catch(function () {
      return false;
    });
    return response.data;
  },
  isConnected: async function () {
    const userData = storage.get('data_from_user');
    if (userData != null) {
      const token = userData.token;
      if (token) {
        const options = {
          headers: {
            Authorization: 'Bearer ' + token
          }
        };
        const response = await axios.post(
          userService.baseURI + userService.jwtApiURI + '/token/validate',
          null,
          options
        ).catch(function () {
          return false;
        });
        return response.data;
      }
    }
    return false;
  },
  logout: function () {
    storage.unset('data_from_user');
  },
  async findUserByEmail(userEmail) {
    const response = await axios.get(
      userService.baseURI + userService.wpApiRestAddURI + '/users?search=' + userEmail
    );
    return response.data;
  },
  async findUserIdByEmail(userEmail) {
    const response = await axios.get(
      userService.baseURI + userService.wpApiRestAddURI + '/users?search=' + userEmail
    );
    return response.data[0].id;
  },
  async findUserById(userId) {
    const response = await axios.get(
      userService.baseURI + userService.wpApiRestAddURI + '/users/' + userId
    ).catch(function () {
      return false;
    });
    return response.data;
  },
  async updateUser(
    userId,
    usernameFromForm,
    userEmailFromForm,
    userLocationFromForm,
    userDescriptionFromForm,
    userUrlFromForm) {
    const result = await axios.post(
        userService.baseURI + userService.customEndPointURI + '/user-update', {
          userid: userId,
          username: usernameFromForm,
          email: userEmailFromForm,
          url: userUrlFromForm,
          description: userDescriptionFromForm,
          location: userLocationFromForm,
        }
      )
      .catch(function () {
        return false;
      });
    return result;
  },
  //! WIP CORS PROBLEM TBC
  async deleteUser(userId) {
    const userData = storage.get('data_from_user');
    if (userData != null) {
      const token = userData.token;
      if (token) {
        const options = {
          headers: {
            Authorization: 'Bearer ' + token
          }
        };
        const result = await axios.post(
          userService.baseURI + userService.customEndPointURI + '/user-delete', {
            userToRemoveId: userId,
          },
          options
        ).catch(function (error) {
          console.log(error);
          return false;
        });
        return result;
      }
    }
    return false;
  },
};
export default userService;