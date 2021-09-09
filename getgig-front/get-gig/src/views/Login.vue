<template>
  <form class="connexion_content" @submit="handleSubmitLoginForm">
    <div class="alert-container" @click="handleAlert">
      <div class="alert">
        <span class="closebtn">{{ alertMessage }}</span>
      </div>
    </div>

    <h1 class="display-5 text-center mt-5 mb-4">Connexion</h1>

    <div class="username row mx-auto col-10 col-md-8 col-lg-8">
      <label for="username">NOM</label>
      <input
        type="text"
        name="username"
        class="register_form-user_name register_form-input"
        placeholder="saisissez votre nom d'utilisateur"
        v-model="usernameFromForm"
      />
    </div>

    <div class="password row mx-auto col-10 col-md-8 col-lg-8">
      <label for="password">Mot de passe</label>
      <input
        type="password"
        name="password"
        class="register_form-user_password register_form-input"
        placeholder="saisissez votre mot de passe"
        v-model="userPasswordFromForm"
      />
    </div>

    <button
      class="register_form-submit_button row mx-auto col-2.8 col-md-8 col-lg-8"
    >
      Valider
    </button>
  </form>
</template>

<script>
import userService from "../services/userService";
import storage from "../plugins/storage.js";
export default {
  name: "Login",
  data() {
    return {
      // user data from form :
      usernameFromForm: "",
      userPasswordFromForm: "",
      // datas status to check :
      usernameEmpty: false,
      passwordEmpty: false,
      // registration status to check :
      loginFailed: false,
      alertMessage: "",
    };
  },
  methods: {
    async handleSubmitLoginForm(evt) {
      evt.preventDefault();
      // checking datas from form : ----------- //
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
      // if no errors
      if (!this.passwordEmpty && !this.usernameEmpty) {
        let userData = await await userService.login(
          this.usernameFromForm,
          this.userPasswordFromForm
        );
        if (userData) {
          storage.set("data_from_user", userData);
          this.logged = true;
          this.loginFailed = false;
          this.$emit("logged-user", userData);

          let alertBox = document.querySelector(".alert-container");
          alertBox.style.display = "flex";
          this.alertMessage = "Bienvenue, " + this.usernameFromForm;

        } else {
          this.loginFailed = true;
          this.logged = false;
          let alertBox = document.querySelector(".alert-container");
          alertBox.style.display = "flex";
          this.alertMessage = "Oops, quelque chose a mal tourné";
        }
      }
    },

    async handleAlert(evt) {
      evt.preventDefault();
      if (this.logged) {
        this.$router.push("/");
      } else {
        let alertBox = document.querySelector(".alert-container");
          alertBox.style.display = "none";
      }
    },
  },
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";
// ----------------------------------
// fixes the page height
.main_container {
  flex-grow: 1;
}
// ----------------------------------
.connexion_content {
  padding-bottom: 5rem;
  width: 100%;
  height: 100vh;
  background-color: $fontColorMediumLight;
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
  border-radius: 0.5rem;
  color: $fontColorExtraLight;
  background-color: $various-menus;
  margin-top: 2rem;
}

.alert-container {
  position: absolute;
  height: 100%;
  width: 100%;
  background-color: rgba(0, 0, 0, 0);
  z-index: 1000;
  top: 0; 
  left: 0;
  display: flex;
  justify-items: center;
  display: none;

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
