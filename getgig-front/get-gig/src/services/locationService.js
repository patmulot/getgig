import axios from 'axios';

const locationService = {
  // setting base URIs :
  //! ---------------------------------------------------------------------------
  //! WARNING FOR THE LOCAL BASE URI , USE YOUR OWN "localhost" url :
  baseURI: "https://api-adresse.data.gouv.fr/search/?q=",
  //! ---------------------------------------------------------------------------
  // enpoints URI :
  // wpApiRestURI: "/wp-json/wp/v2",
  // embeddedURI: "?_embed=true",

  async loadLocation(requestedLocation) {
    const response = await axios.get(
      locationService.baseURI + requestedLocation
    ).catch(function () {
      console.log("error");
      return false;
    });
    return response.data.features;
  },
}

export default locationService;