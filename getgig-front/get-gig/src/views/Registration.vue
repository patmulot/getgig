<template>
  <div class="registration container">
    <h1 class="display-5 text-center mt-5 mb-4">Inscription</h1>
    <form action="" class="register_form" @submit="handleSubmitRegisterForm">
      <div class="alert-container" @click="handleAlert">
        <div class="alert">
          <span class="closebtn">{{ alertMessage }}</span>
        </div>
      </div>

      <div class="role row mx-auto col-10 col-md-8 col-lg-8">
        <label class="ms-1 mt-4 fs-5" for="role">
          SELECTIONNEZ VOTRE RÔLE</label
        >
        <select
          name="role"
          id="role"
          class="register_form-role_selector register_form-input"
          @change="selectUserRole"
        >
          <option value="artist" class="register_form-role_selector-option">
            Artiste
          </option>
          <option value="organizer" class="register_form-role_selector-option">
            Organisateur d'évènements
          </option>
        </select>
      </div>

      <div class="username row mx-auto col-10 col-md-8 col-lg-8">
        <label for="username">NOM DE L'UTILISATEUR</label>
        <input
          type="text"
          name="username"
          class="register_form-user_name register_form-input"
          placeholder="saisissez votre nom d'utilisateur"
          v-model="usernameFromForm"
        />
      </div>

      <div class="email row mx-auto col-10 col-md-8 col-lg-8">
        <label for="email">EMAIL</label>
        <input
          type="email"
          name="email"
          class="register_form-user_email register_form-input"
          placeholder="saisissez votre email"
          v-model="userEmailFromForm"
        />
      </div>

      <div class="password row mx-auto col-10 col-md-8 col-lg-8">
        <label for="password">MOT DE PASSE</label>
        <input
          type="password"
          name="password"
          class="register_form-user_password register_form-input"
          placeholder="saisissez votre mot de passe"
          v-model="userPasswordFromForm"
        />
      </div>

      <div class="town row mx-auto col-10 col-md-8 col-lg-8">
        <label for="town"
          >LOCALITE : <em v-if="selectedCity">{{ selectedCity }}</em></label
        >
        <div>
          <input
            type="text"
            name="town"
            class="register_form-user_name register_form-input"
            placeholder="Nom de la ville"
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

      <div class="major row mb-3 mx-auto col-10 col-md-8 col-lg-8">
        <label class="ms-1 mt-4 fs-6"
          ><input
            class="form-check-input"
            type="checkbox"
            id="checkboxNoLabel"
            value=""
            aria-label="..."
          />
          Je certifie sur l'honneur etre majeur
        </label>
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
import userService from "../services/userService.js";
import locationService from "../services/locationService.js";
export default {
  name: "Registration",
  data() {
    return {
      // user data from form :
      usernameFromForm: "",
      userPasswordFromForm: "",
      userEmailFromForm: "",
      // user meta :
      userRoleFromForm: "",
      userLocationFromForm: "",
      locationsResponse: [],
      cityDatas: [],
      selectedCity: "",
      // datas status to check :
      usernameEmptyFromForm: false,
      emailEmpty: false,
      passwordEmpty: false,
      roleEmpty: false,
      cityEmpty: false,
      // registration status to check :
      registrationFailed: false,
      alertMessage: "",
    };
  },
  methods: {
    selectUserRole(evt) {
      evt.preventDefault();
      this.userRoleFromForm = evt.currentTarget.value;
    },
    async handleSubmitRegisterForm(evt) {
      evt.preventDefault();
      // checking data from form empty conditions :
      if (this.usernameFromForm == "") {
        this.usernameEmpty = true;
      } else {
        this.usernameEmpty = false;
      }
      if (this.userPasswordFromForm == "") {
        this.passwordEmpty = true;
      } else {
        this.passwordEmpty = false;
      }
      if (this.userEmailFromForm == "") {
        this.emailEmpty = true;
      } else {
        this.emailEmpty = false;
      }
      if (this.userRoleFromForm == "") {
        this.roleEmpty = true;
      } else {
        this.roleEmpty = false;
      }
      if (this.selectedCity == "") {
        this.cityEmpty = true;
      } else {
        this.cityEmpty = false;
      }
      // if no errors
      if (!this.passwordEmpty && !this.emailEmpty) {
        let result = await userService.register(
          this.usernameFromForm,
          this.userPasswordFromForm,
          this.userEmailFromForm,
          // user meta :
          this.userRoleFromForm,
          this.selectedCity
        );
        if (result) {
          let alertBox = document.querySelector(".alert-container");
          alertBox.style.display = "flex";
          this.alertMessage =
            "Félicitations, vous avez crée votre compte avec succès";

          if (result.success == true) {
            return;
          }
        } else {
          this.registrationFailed = true;
        }
      } else {
        let alertBox = document.querySelector(".alert-container");
        alertBox.style.display = "flex";
        this.alertMessage = "Oops, quelque chose a mal tourné";
        this.registrationFailed = true;
      }
      //! ------- TEMPORAIRE ---------------------
      //! add an automatic post upon user creation for fetch in user/API
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
    async handleAlert(evt) {
      evt.preventDefault();
      if (this.registrationFailed) {
        this.$router.go();
      } else {
        this.$router.push("/Login");
      }
    },
  },
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";
// ----------------------------------
// fixes the page height
.container {
  flex-grow: 1;
}
// ----------------------------------

.registration {
  width: 100%;
  margin-top: 80px;
  background-color: $fontColorMediumLight;
  padding-bottom: 5rem;
  scroll-margin-top: 0;
}
h1 {
  padding-top: 6rem;
  color: $fontColorExtraLight;
}
label {
  padding-top: 1.5rem;
  padding-bottom: 0.3rem;
  color: $fontColorExtraLight;
}
input {
  padding: 0.5rem;
  border-bottom-right-radius: 14px 14px;
}

.major > p {
  color: $fontColorExtraLight;
  padding-top: 2rem;
}

button {
  padding: 0.5rem;
  margin: 0.5rem;
  border-radius: 0.5rem;
  color: $fontColorMediumDark;
}
.register_form-submit_button {
  padding: 0.5rem;
  border-radius: 0.5rem;
  color: $fontColorExtraLight;
  background-color: $various-menus;
  margin-top: 2rem;
}

.alert-container {
  position: absolute;
  min-height: 100%;
  height: 100%;
  width: 100%;
  background-color: rgba(0, 0, 0, 0);
  z-index: 1000;
  // top: 0;
  left: 0;
  display: flex;
  justify-items: center;
  display: none;
  cursor: pointer;

  .alert {
    background-color: $various-menus;
    padding: 50px;
    margin: auto;
    border-radius: 0.5rem;
    box-shadow: 0px 0px 10rem rgba(0, 0, 0, 0.4);

    .closebtn {
      color: $fontColorExtraLight;
      font-size: 22px;
      line-height: 20px;
      cursor: pointer;
      transition: 0.3s;
    }
  }
}
</style>
