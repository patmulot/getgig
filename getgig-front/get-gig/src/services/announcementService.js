import axios from 'axios';
import storage from '../plugins/storage.js';
const announcementService = {
  // setting base URIs :
  //! WARNING FOR THE LOCAL BASE URI , USE YOUR OWN "localhost" url :
  // baseURI: "http://localhost/neo/getgig/projet-get-gig/public/index.php",
  baseURI: "http://localhost/neo/my-projects/getgig/getgig-back/public/index.php",
  //! ---------------------------------------------------------------------------
  // enpoints URI :
  wpApiRestURI: "/wp-json/wp/v2",
  customEndPointURI: "/wp-json/getgigwp/v1",
  embeddedURI: "?_embed=true",

  async loadAnnouncements() {
    const response = await axios.get(
      announcementService.baseURI + announcementService.wpApiRestURI + '/announcements' + announcementService.embeddedURI
    );
    return response.data;
  },

  async loadAnnouncementsByType(typeNumber) {
    const response = await axios.get(
      announcementService.baseURI + announcementService.wpApiRestURI + '/announcements' + announcementService.embeddedURI + '&Type=' + typeNumber
    );
    return response.data;
  },

  async loadAnnouncementsByAuthor(authorNumber) {
    const response = await axios.get(
      announcementService.baseURI + announcementService.wpApiRestURI + '/announcements' + announcementService.embeddedURI + '&author=' + authorNumber
    );
    return response.data;
  },

  async loadAnnouncementByAuthorAndType(authorNumber, typeNumber) {
    const response = await axios.get(
      announcementService.baseURI + announcementService.wpApiRestURI + '/announcements' + announcementService.embeddedURI + '&author=' + authorNumber + '&Type=' + typeNumber
    );
    return response.data;
  },

  async loadAnnouncementById(announcementId) {
    const response = await axios.get(
      announcementService.baseURI + announcementService.wpApiRestURI + '/announcements/' + announcementId + announcementService.embeddedURI
    );
    return response.data;
  },

  //! WIP TBC
  async loadAnnouncementsByCity() {
    const response = await axios.get(
      announcementService.baseURI + announcementService.wpApiRestURI + '/announcements/' + announcementService.embeddedURI + '&author=33'
    );
    return response.data;
  },
  //! WIP TBC

  async saveAnnouncement(title, role, imageId, location, content, start_date, end_date) {
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
          announcementService.baseURI + announcementService.customEndPointURI + '/announcement-save', {
            announcementTitle: title,
            announcementRole: role,
            announcementImageId: imageId,
            announcementLocation: location,
            announcementContent: content,
            announcementStartDate: start_date,
            announcementEndDate: end_date,
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
  async uploadImage(image) {
    
    let formData = new FormData();
    formData.append("image", image);

    const userData = storage.get('data_from_user');
    const token = userData.token;
    const result = await axios.post(
      announcementService.baseURI + announcementService.customEndPointURI + '/upload-image',
      formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Authorization': 'Bearer ' + token
        }
      }
    );
    return result.data;
  },
  async updateAnnouncement(announcementId) {
    return announcementId;
  },
  //! WIP TBC not working : 403 forbiden ou 401 unauthorized
  async deleteAnnouncement(announcementId) {
    const userData = storage.get('data_from_user');
    const token = userData.token;
    const options = {
      headers: {
        Authorization: 'Bearer ' + token
      }
    };
    const result = await axios.delete(
      announcementService.baseURI + announcementService.wpApiRestURI + '/announcements/' + announcementId + "?force=true",
      options
    ).then(console.log(announcementId)).catch(function (error) {
      console.log(error);
      return false;
    });
    return result;
  },
}

export default announcementService;