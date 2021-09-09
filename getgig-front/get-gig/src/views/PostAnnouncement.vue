<template>
  <div class="annoucement-post container">
    <h1 class="display-5 text-center mt-5 mb-4">
      <i class="fab fa-usps"></i> Publier votre annonce
    </h1>
    <h2 class="bienvenue text-center mt-5 mb-4">
      Bienvenue <span>{{ this.userConnected.user_display_name }} !</span>
    </h2>
    <form
      action=""
      class="announcement_form"
      @submit="handleSubmitAnnouncementForm"
    >
      <div class="announcement-title row mx-auto col-10 col-md-8 col-lg-8">
        <label for="announcement-title">TITRE ** (Attention ! la saisie des caractères Min/Maj sera reproduite dans l'état)</label>
        <input
          type="text"
          name="announcement-title"
          class="announcement_form announcement_form-input"
          placeholder="saisissez le titre de votre annonce"
          v-model="announcementTitleFromForm"
        />
      </div>

      <div class="role row mx-auto col-10 col-md-8 col-lg-8">
        <label class="ms-1 mt-4 fs-5" for="role">
          Selectionnez votre role</label
        >
        <select
          name="role"
          id="role"
          class="register_form-role_selector register_form-input"
          @change="selectAnnouncementType"
        >
          <option value="0" selected class="register_form-role_selector-option">
            choisissez une option
          </option>
          <option value="artiste" class="register_form-role_selector-option">
            Artiste
          </option>
          <option
            value="organisateur"
            class="register_form-role_selector-option"
          >
            Organisateur d'évènements
          </option>
        </select>
      </div>

      <div class="add-image row mx-auto col-10 col-md-8 col-lg-8">
        <label>
          Poster une image <input type="file" @change="previewFiles" />
          <img v-if="image" :src="image" />
          <input v-model="imageId" type="hidden" />
        </label>
      </div>

      <div class="town row mx-auto col-10 col-md-8 col-lg-8">
        <label for="town"
          >LOCALITE : <span v-if="selectedCity">{{ selectedCity }}</span></label
        >
        <div class="location_inputs_container">
          <input
            type="text"
            name="town"
            class="register_form-user_name register_form-input"
            placeholder="Nom de la ville"
            v-model="userLocationFromForm"
          />
          <button class="search_location" @click="handleClickOnLoadCityButton">
            <i class="fas fa-search-location"></i>
          </button>
        </div>
        <div
          class="select_location-button-container"
          v-for="oneCityData in cityDatas"
          :key="oneCityData.id"
        >
          <button
            class="response_one_location"
            :value="oneCityData.label"
            @click="handleClickOnCity"
            :data-city-name="oneCityData.city"
          >
            <span>{{ oneCityData.label }}</span>
          </button>
        </div>
      </div>

      <div class="start-date row mx-auto col-10 col-md-8 col-lg-8">
        <div>
          <label for="start-date">DATE début </label>
          <input
            type="date"
            name="start-date"
            class="date-input"
            v-model="announcementStartDateFromForm"
          />
        </div>
      </div>

      <div class="end-date mb-4 row mx-auto col-10 col-md-8 col-lg-8">
        <div>
          <label for="end-date">DATE de fin </label>
          <input
            type="date"
            name="end-date"
            class="date-input"
            v-model="announcementEndDateFromForm"
          />
        </div>
      </div>

      <div class="content row mx-auto mb-5 col-10 col-md-8 col-lg-8">
        <label for="text-annonce">CONTENU</label>
        <textarea
          class="form-control"
          placeholder="saisissez le détail de votre annonce maximum 1000 caractères"
          maxlength="1000"
          id="floatingTextarea"
          v-model="announcementContentFromForm"
        ></textarea>
      </div>

      <button
        class="
          register_form-submit_button
          row
          mx-auto
          col-2.8 col-md-8 col-lg-8
        "
      >
        Valider
      </button>
    </form>
  </div>
</template>

<script>
import announcementService from "../services/announcementService.js";
import locationService from "../services/locationService.js";
import storage from "../plugins/storage.js";

export default {
  name: "PostAnnouncement",

  async created() {
    this.checkUserLogged();
  },

  methods: {
    async checkUserLogged() {
      this.userConnected = await storage.get("data_from_user");
      return;
    },

    async handleClickOnLoadCityButton(evt) {
      evt.preventDefault();
      const results = await locationService.loadLocation(
        this.userLocationFromForm
      );
      this.locationsResponse = await results;
      for (let oneLocation in this.locationsResponse) {
        this.cityDatas.push(this.locationsResponse[oneLocation].properties);
      }
    },

    handleClickOnCity(evt) {
      evt.preventDefault();
      this.selectedCity = evt.currentTarget.dataset.cityName;

      let allButtonsToHyde = evt.currentTarget
        .closest(".town")
        .querySelectorAll(".select_location-button-container");

      for (let oneButtonToHyde of allButtonsToHyde) {
        oneButtonToHyde.style.display = "none";
      }
    },

    selectAnnouncementType(evt) {
      evt.preventDefault();
      this.announcementTypeFromForm = evt.currentTarget.value;
      return this.announcementTypeFromForm;
    },

    async previewFiles(evt) {
      evt.preventDefault();
      const image = evt.currentTarget.files[0];
      let imageResult = await announcementService.uploadImage(image);

      this.image = imageResult.image.url;
      this.imageId = imageResult.image.id;
    },

    async handleSubmitAnnouncementForm(evt) {
      evt.preventDefault();
      // checking data from form empty conditions: ----------- //
      if (this.announcementTitleFromForm == "") {
        this.titleEmpty = true;
      } else {
        this.titleEmpty = false;
      }

      if (this.announcementTypeFromForm == "") {
        this.typeEmpty = true;
      } else {
        this.typeEmpty = false;
      }

      if (this.selectedCity == "") {
        this.cityEmpty = true;
      } else {
        this.cityEmpty = false;
      }

      if (this.announcementContentFromForm == "") {
        this.contentEmpty = true;
      } else {
        this.contentEmpty = false;
      }

      if (this.announcementStartDateFromForm == "") {
        this.startingDateEmpty = true;
      } else {
        this.startingDateEmpty = false;
      }

      if (this.announcementEndDateFromForm == "") {
        this.endingDateEmpty = true;
      } else {
        this.endingDateEmpty = false;
      }

      if (
        this.titleEmpty === false &&
        this.typeEmpty === false &&
        this.cityEmpty === false &&
        this.contentEmpty === false &&
        this.startingDateEmpty === false &&
        this.endingDateEmpty === false
      ) {
        const result = await announcementService.saveAnnouncement(
          this.announcementTitleFromForm,
          this.announcementTypeFromForm,
          this.imageId,
          this.selectedCity,
          this.announcementContentFromForm,
          this.announcementStartDateFromForm,
          this.announcementEndDateFromForm
        );

        if (result) {
          this.$router.push("MyAnnouncement");
        } else {
          this.createFail = true;
        }
      }
    },
  },

  data() {
    return {
      announcementTitleFromForm: "",
      announcementTypeFromForm: "",
      image: "",
      imageId: 0,
      userLocationFromForm: "",
      locationsResponse: [],
      cityDatas: [],
      selectedCity: "",
      announcementStartDateFromForm: "",
      announcementEndDateFromForm: "",
      announcementContentFromForm: "",
      currentUser: false,
      userConnected: false,

      titleEmpty: false,
      typeEmpty: false,
      contentEmpty: false,
    
      createFail: false,
      
      cityEmpty: false,
      startingDateEmpty: false,
      endingDateEmpty: false,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";

.bienvenue {
  color: #6d3844;
  font-size: 1.3rem;
}
.annoucement-post {
  width: 100%;
  margin-top: 80px;
  background-color: $fontColorMediumLight;
  padding-bottom: 5rem;
}

h1 {
  padding-top: 6rem;
  color: $fontColorExtraLight;
}

label {
  padding-top: 1.3rem;
  padding-bottom: 0.3rem;
  color: $fontColorExtraLight;
}
input {
  padding: 0.5rem;
  border-bottom-right-radius: 14px 14px;
}

.add-image {
  padding-top: 3rem;
  color: $fontColorExtraLight;
  font-size: 1.1rem;
}

.poster-image {
  font-size: 2rem;
  margin-left: 1.5rem;
}

.start-date input {
  margin-left: 1rem;
  margin-right: 1rem;
}
.end-date input {
  margin-left: 1rem;
  margin-right: 1rem;
}

button {
  padding: 0.5rem;
  border-radius: 0.5rem;
  color: $fontColorExtraLight;
  background-color: $various-menus;
  margin-top: 0.5rem;
  margin-left: 4rem;
}
.location_inputs_container {
  display: flex;
  .register_form-user_name {
    width: 100%;
  }
  .search_location {
    margin: 0;
  }
  margin-top: 0.5rem;
}
.response_one_location {
  width: 100%;
  margin: 0;
}
</style>