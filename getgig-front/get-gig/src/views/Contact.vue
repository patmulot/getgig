<template>
  <div class="main_container">
    <form action="" class="contact_form" @submit="handleSubmitContactForm">
      <h1><i class="fas fa-user-friends"></i> Contact</h1>
      <div
        class="
          organizer-or-artist-name
          text-center
          row
          mx-auto
          col-10 col-md-8 col-lg-8
        "
      >
        <h2 class="card-title">Bienvenue !</h2>

        <p class="contact-profile">{{ messageObject }}</p>
      </div>
      <div class="contact-phone row mx-auto col-10 col-md-11 col-lg-8">
        <label for="contact-phone">Numéro de téléphone (facultatif)</label>
        <input
          type="text"
          name="contact-phone"
          class="contact-phone_form-input"
          placeholder="saisissez votre numéro de téléphone"
          v-model="contactPhoneFromUserForm"
        />
      </div>
      <div class="message-content row mx-auto mb-5 col-10 col-md-11 col-lg-8">
        <label for="message-content" v-if="isMessageForSupport">Objet </label>
        <input
          class="message-content_form-control"
          placeholder="saisissez l'objet de votre message"
          id="floatingTextarea"
          maxlength="100"
          v-model="supportObject"
          v-if="isMessageForSupport"
        />
        <label for="message-content">Message</label>
        <textarea
          class="message-content_form-control"
          placeholder="saisissez votre message maximum 300 caractères"
          id="floatingTextarea"
          maxlength="300"
          v-model="messageContentFromForm"
        ></textarea>
      </div>
      <button
        class="
          register_form-submit_button
          row
          mx-auto
          col-2.8 col-md-11 col-lg-8
        "
      >
        Valider
      </button>
    </form>
  </div>
</template>

<script>
import messageService from "../services/messageService.js";
import storage from "../plugins/storage.js";
import userService from "../services/userService.js";
export default {
  name: "Contact",
  data() {
    return {
      userConnected: false,
      senderId: 0,
      recipientId: 0,
      messageContentFromForm: "",
      typeSelectedFromUserForm: "",
      contactPhoneFromUserForm: "",
      userName: "",
      messagingFailed: false,
      currentUser: false,
      isUserRole: false,
      messageObject: "",
      isMessageForSupport: false,
      supportObject: "",
    };
  },
  async created() {
    this.checkUserLogged();
  },
  methods: {
    async checkUserLogged() {
      this.userConnected = await storage.get("data_from_user");
      this.userName = this.userConnected.user_nicename;
      if (this.userConnected) {
        const currentUserEmail = storage.get("data_from_user").user_email;
        this.senderId = await userService.findUserIdByEmail(currentUserEmail);
        this.currentUser = await userService.findUserById(
          parseInt(this.senderId)
        );
        if (this.currentUser.slug === "organizer") {
          this.userRole = "organisateur";
        } else if (this.currentUser.slug === "artist") {
          this.userRole = "artiste";
        }
        if (this.$route.params.id !== undefined) {
          this.recipientId = this.$route.params.id;
          this.messageObject = "vous êtes intéressé(e) par cette annonce";
          this.typeSelectedFromUserForm = this.userRole;
        } else {
          this.recipientId = 1; 
          this.messageObject = "vous êtes en train de contacter le Support Technique";
          this.isMessageForSupport = true;
        }
      } else {
        this.$router.push("/Login");
      }
      return;
    },
    selectUserRole(evt) {
      evt.preventDefault();
      this.typeSelectedFromUserForm = evt.currentTarget.value;
    },
    async handleSubmitContactForm(evt) {
      evt.preventDefault();
      let selectedType = "";
      let phoneNumber = "";
      let messageObject = "";
      if (this.userRole !== "") {
        selectedType = "";
      }
      if (
        this.typeSelectedFromUserForm !== "" ||
        this.typeSelectedFromUserForm !== null
      ) {
        selectedType = "";
      }
      if (this.contactPhoneFromUserForm !== "") {
        phoneNumber = "<br>Mon numéro : " + this.contactPhoneFromUserForm;
      }
      if (this.supportObject !== "") {
        messageObject =
          "Objet du message : " + this.supportObject + "</br></br>";
      }
      let messageToSend =
        messageObject +
        this.messageContentFromForm +
        selectedType +
        phoneNumber;
      if (this.messageContentFromForm !== "") {
        let messageInputElement = evt.target[0];
        let result = await messageService.sendMessage(
          this.senderId,
          this.recipientId,
          messageToSend
        );
        if (result) {
          this.$router.push("/Messages");
          if (result.success == true) {
            return;
          }
        }
        this.messagingFailed = true;
        messageInputElement.value = "";
        this.messageContentFromForm = "";
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";

.main_container {
  flex-grow: 1;
  width: 100%;
  height: 100vh;
  margin-top: 60px;
  background-color: $fontColorMediumLight;
  padding-bottom: 5rem;
}

.bienvenue {
  color: #6d3844;
  font-size: 1.3rem;
}
h1 {
  text-align: center;
  margin-top: 6rem;
  color: $fontColorExtraLight;
}
.card-title {
  color: $various-text;
  margin-top: 2rem;
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
  margin-top: 2rem;
}
</style>