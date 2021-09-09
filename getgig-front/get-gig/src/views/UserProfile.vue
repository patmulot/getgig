<template>
  <div class="user-profile-container container">
    <div class="row">
      <div class="col-12 text-center">
        <h1>Votre profil</h1>
        <h2 class="card-title">Bienvenue {{ userName }} !</h2>

        <div
          class="card-body user_info-container user_info-container_display"
          :key="componentKey"
        >
          <div class="user-profile-text text-start ms-2">
            <div>
              <span class="card-text col-12"
                >Nom de login : {{ userLogin }}</span
              >
            </div>
            <div>
              <span class="card-text col-12">Nom : {{ userName }}</span>
            </div>
            <div>
              <span class="card-text col-12">Email : {{ userEmail }}</span>
            </div>
            <div>
              <span class="card-text col-12">Ville : {{ selectedCity }} </span>
            </div>
            <div>
              <span class="card-text col-12"
                >Description de votre profil: {{ userDescription }}
              </span>
            </div>
            <div>
              <span class="card-text col-12"
                >URL : <a :href="userUrl">{{ userUrl }} </a></span
              >
            </div>
          </div>
        </div>

        <div class="link_profile-change row edit_buttons-container">
          <button @click="handleClickOnEditButton">Editer votre profil</button>
          <button class="delete_button" @click="handleClickOnDeleteButton">
            Supprimer votre compte
          </button>
          <button
            class="confirm_button"
            v-if="confirmDelete"
            @click="handleClickOnConfirmButton"
          >
            Confirmez-vous la suppression ?
          </button>
        </div>

        <div class="edit-form-container user_edit_form_display">
          <form action="" @submit="handleSubmitEditUserForm">
            <div class="username row mx-auto col-10 col-md-8 col-lg-8">
              <label for="username">confirmez votre NOM</label>
              <input
                type="text"
                name="username"
                class="register_form-user_name register_form-input"
                :placeholder="userName"
                v-model="usernameFromForm"
              />
            </div>

            <div class="email row mx-auto col-10 col-md-8 col-lg-8">
              <label for="email">confirmez votre EMAIL </label>
              <input
                type="email"
                name="email"
                class="register_form-user_email register_form-input"
                :placeholder="userEmail"
                v-model="userEmailFromForm"
              />
            </div>

            <div class="town row mx-auto col-10 col-md-8 col-lg-8">
              <label for="town"
                >confirmez votre LOCALITE :
                <span v-if="selectedCity">{{ selectedCity }}</span></label
              >
              <div>
                <input
                  type="text"
                  name="town"
                  class="register_form-user_name register_form-input"
                  placeholder="confirmez votre localité"
                  v-model="userLocationFromForm"
                />
                <button @click="handleClickOnLoadCityButton">
                  Rechercher la ville
                </button>
              </div>
              <div
                class="select_location-button-container"
                v-for="oneCityData in cityDatas"
                :key="oneCityData.id"
              >
                <button
                  :value="oneCityData.label"
                  @click="handleClickOnCity"
                  :data-city-name="oneCityData.city"
                >
                  <span>{{ oneCityData.label }}</span>
                </button>
              </div>
            </div>

            <div class="userdescription row mx-auto col-10 col-md-8 col-lg-8">
              <label for="userdescription">DESCRIPTION</label>
              <textarea
                name="userdescription"
                class="
                  register_form-user_name register_form-input
                  description_input
                "
                placeholder="saisissez une description"
                maxlength="1000"
                v-model="userDescriptionFromForm"
              />
            </div>

            <div class="userurl row mx-auto col-10 col-md-8 col-lg-8">
              <label for="userurl">URL</label>
              <input
                type="text"
                name="userurl"
                class="register_form-user_name register_form-input"
                placeholder="saisissez l'URL de votre site"
                v-model="userUrlFromForm"
              />
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
            <button
              class="
                register_form-submit_button
                row
                mx-auto
                col-2.8 col-md-8 col-lg-8
              "
              @click="cancelEditUser"
            >
              Annuler
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import storage from "../plugins/storage.js";
import userService from "../services/userService.js";
import locationService from "../services/locationService.js";
export default {
  name: "UserProfile",
  data() {
    return {
      componentKey: 0,
      // all user's datas :
      userId: "",
      userLogin: "",
      userName: "",
      userEmail: "saisissez votre email",
      userUrl: "",
      userDescription: "",
      userType: "",
      userLocation: "",
      // user data from form :
      usernameFromForm: "",
      userEmailFromForm: "",
      userLocationFromForm: "",
      userDescriptionFromForm: "",
      userUrlFromForm: "",
      locationsResponse: [],
      selectedCity: "",
      // others datas :
      confirmDelete: false,
      cityDatas: [],
      userProfileDatas: [],
      // update status to check :
      // updateFailed: false,
    };
  },
  methods: {
    checkInput() {
      if (this.usernameFromForm === "") {
        this.usernameFromForm = this.userName;
      }
      if (this.userEmailFromForm === "") {
        this.userEmailFromForm = this.userEmail;
      }
      if (this.userLocationFromForm === "") {
        this.userLocationFromForm = this.userLocation;
      }
      if (this.userDescriptionFromForm === "") {
        this.userDescriptionFromForm = this.userDescription;
      }
      if (this.userUrlFromForm === "") {
        this.userUrlFromForm = this.userUrl;
      }
    },
    async handleClickOnLoadCityButton(evt) {
      evt.preventDefault();
      const results = locationService.loadLocation(this.userLocationFromForm);
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
    async checkUserLogged() {
      this.userConnected = await storage.get("data_from_user");
      if (this.userConnected) {
        this.userLogin = this.userConnected.user_login;
        this.userEmail = this.userConnected.user_email;
        this.userId = this.userConnected.user_id;

        this.userProfileDatas = await userService.findUserById(this.userId);
        this.userName = this.userProfileDatas.name;
        if (this.userProfileDatas.userlocation !== "") {
          this.userLocation = this.userProfileDatas.acf.userlocation;
        }
        this.userUrl = this.userProfileDatas.url;
        if (this.userProfileDatas.description !== "") {
          this.userDescription = this.userProfileDatas.description;
        }
        if (this.userProfileDatas.slug == "organizer") {
          this.userType = "Organisateur";
        } else if (this.userProfileDatas.slug == "artist") {
          this.userType = "Artiste";
        }
      } else {
        this.$router.push("/Login");
      }
    },
    handleClickOnEditButton(evt) {
      evt.preventDefault();
      let userInfoElement = document.querySelector(
        ".user_info-container_display"
      );
      let editUserFormElement = document.querySelector(
        ".user_edit_form_display"
      );
      let editButtonsElements = document.querySelector(
        ".edit_buttons-container"
      );
      userInfoElement.style.display = "none";
      editUserFormElement.style.display = "flex";
      editButtonsElements.style.display = "none";
    },
    displayBackUserProfile() {
      let userInfoElement = document.querySelector(
        ".user_info-container_display"
      );
      let editUserFormElement = document.querySelector(
        ".user_edit_form_display"
      );
      let editButtonsElements = document.querySelector(
        ".edit_buttons-container"
      );
      userInfoElement.style.display = "block";
      editUserFormElement.style.display = "none";
      editButtonsElements.style.display = "block";
    },
    cancelEditUser() {
      this.displayBackUserProfile();
    },
    handleClickOnDeleteButton(evt) {
      evt.preventDefault();
      this.confirmDelete = true;
      let deleteButtonElement = evt.currentTarget
        .closest(".edit_buttons-container")
        .querySelector(".delete_button");
      deleteButtonElement.style.display = "none";
    },
    handleClickOnConfirmButton(evt) {
      evt.preventDefault();
      userService.deleteUser(this.userId); 
      this.$router.push("/Registration");
    },
    // ------- SUBMITTING EDIT FORM ----------- //
    async handleSubmitEditUserForm(evt) {
      evt.preventDefault();
      this.checkInput();
      await userService.updateUser(
        this.userId,
        this.usernameFromForm,
        this.userEmailFromForm,
        this.selectedCity,
        this.userDescriptionFromForm,
        this.userUrlFromForm
      );
      this.checkUserLogged();
      this.displayBackUserProfile();
    },
  },
  async created() {
    this.checkUserLogged();
  },
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";

.user_edit_form_display {
  display: none;
}
.change_password {
  color: red;
}
.user-profile-container {
  margin-top: 6rem;
  background-color: $fontColorMediumLight;
  padding: 1rem;
  flex-grow: 1;
}

h1 {
  margin-top: 6rem;
  color: $fontColorExtraLight;
}
.card-title {
  color: $various-text;
  margin-top: 2rem;
}
.link_profile-change {
  padding: 2rem;
  font-size: 1rem;
  display: block;
}
label {
  padding-top: 1.5rem;
  padding-bottom: 0.3rem;
  color: $fontColorExtraLight;
  text-align: start;
}
input {
  padding: 0.5rem;
  border-bottom-right-radius: 14px 14px;
}
button {
  padding: 0.5rem;
  border-radius: 0.5rem;
  color: $fontColorExtraLight;
  background-color: $various-menus;
  margin-top: 1.5rem;
}

.description_input {
  height: 15rem;
}

.user-profile-text {
  color: $fontColorExtraLight;
  font-size: 1.2rem;
}
</style>