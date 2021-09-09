import axios from 'axios';
import storage from '../plugins/storage.js';
const messageService = {
  // setting base URIs :
  //! ---------------------------------------------------------------------------
  //! WARNING FOR THE LOCAL BASE URI , USE YOUR OWN "localhost" url :
  // baseURI: "http://localhost/neo/getgig/projet-get-gig/public/index.php",
  baseURI: "http://localhost/neo/my-projects/getgig/getgig-back/public/index.php",
  //! ---------------------------------------------------------------------------
  // enpoints URI :
  // wpApiRestAddURI: "/wp-json/wp/v2",
  customEndPointURI: "/wp-json/getgigwp/v1",
  jwtApiURI: "/wp-json/jwt-auth/v1",

  async loadAllRecipients(senderId) {
    const response = await axios.get(
      messageService.baseURI + messageService.customEndPointURI + '/messages/sender/' + senderId
    );
    return response.data;
  },
  async loadAllContacts(senderId) {
    const response = await axios.get(
      messageService.baseURI + messageService.customEndPointURI + '/messages/contacts/sender/' + senderId + "/recipient/" + senderId
    );
    return response.data;
  },
  async loadAllMessagesThread(senderId, recipientId) {
    const response = await axios.get(
      messageService.baseURI + messageService.customEndPointURI + '/messages/sender/' + senderId + "/recipient/" + recipientId
    );
    return response.data;
  },
  async sendMessage(sender, recipient, content) {
    const userData = storage.get('data_from_user');
    if (userData != null) {
      const token = userData.token;
      if (token) {
        const result = await axios.post(
          messageService.baseURI + messageService.customEndPointURI + '/message-save', {
            senderid: sender,
            recipientid: recipient,
            message: content,
          },
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
export default messageService;