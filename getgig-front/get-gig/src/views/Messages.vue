<template>
  <div class="messaging container">
    <h1 class="display-5 text-center mt-5 mb-4">Mes messages</h1>

    <div class="archives container">
      <div class="archives row">
        <div class="users_contact col-12 col-sm-5">
          <div class="user_to_contact ms-4 col-10 col-md-8 col-lg-8">
            <h3>mes contacts</h3>
            <div
              class="contact_button-container"
              v-for="oneRecipient in recipientsList"
              :key="oneRecipient.id"
            >
              <button
                class="contact_button col-10 col-md-8 col-lg-8 d-sm-inline-flex"
                :data-recipient-id="oneRecipient.id"
                @click="handClickOnRecipientButton"
              >
                {{ oneRecipient.name }}
              </button>
            </div>
            <button
              class="
                display_contacts-button
                contacts-display
                col-10 col-md-8 col-lg-8 d-sm-none
              "
              @click="handleClickOnDisplayContacts"
            >
              <i class="fas fa-angle-double-down"></i>
            </button>
            <button
              class="
                display_contacts-button
                contacts-hyde
                col-10 col-md-8 col-lg-8 d-sm-none
              "
              @click="handleClickOnHydeContacts"
            >
              <i class="fas fa-angle-double-up"></i>
            </button>
          </div>
        </div>
        <!-- -------------------------- ERROR -------------------------- -->
        <div id="no_user_message" class="archive_messages col-12 col-sm-6">
          <div class="row">
            <h3>aucun utilisateur trouvé</h3>
          </div>
        </div>
        <!-- ---------------------- SELECT RECIPIENT ---------------------- -->
        <div
          id="no_recipient_selected"
          class="archive_messages col-12 col-sm-6"
        >
          <div class="row">
            <h3>choisissez votre contact</h3>
            <h3 v-if="isContact">(chargement des contacts en cours...)</h3>
          </div>
        </div>
        <!-- ----------------------------------------------------------- -->
        <div
          class="archive_messages col-12 col-sm-6"
          :scrollTop="scrollValue"
          v-if="currentRecipientName"
        >
          <h3>{{ currentRecipientName }}</h3>
          <div
            class="row text-start"
            v-for="oneMessage in allMessageThreads"
            :key="oneMessage.id"
          >
            <div
              :class="oneMessage.from"
              class="single_message"
              v-if="oneMessage.name"
            >
              <span>{{ oneMessage.name }}</span> -
              <span>{{ oneMessage.date }}</span>
              <!--API user_name & datetime -->
              <div class="text_message" v-html="oneMessage.content"></div>
            </div>
          </div>
        </div>
        <form class="new-message" action="" @submit="handleSubmitSendMessage">
          <div class="content row mx-auto mb-5 col-10 col-md-10 col-lg-6">
            <label for="new-message"> votre message : </label>
            <textarea
              class="form-control"
              rows="5"
              placeholder="saisissez votre message max 500 caracteres"
              minlength="4"
              maxlength="500"
              id="new-message"
              v-model="messageContentFromForm"
            ></textarea>
            <button
              class="
                register_form-submit_button send_message-button
                row
                mx-auto
                col-2.8 col-md-3 col-lg-3
              "
            >
              Envoyer <i class="fas fa-paper-plane send_icon"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import messageService from "../services/messageService.js";
import storage from "../plugins/storage.js";
import userService from "../services/userService.js";
export default {
  name: "Messages",
  data() {
    return {
      userConnected: false,
      senderId: 0,
      recipientId: 0,
      messageContentFromForm: "",
      currentRecipientName: false,
      currentRecipient: false,
      allMessageThreads: [],
      allSenderMessageThreads: [],
      recipientsList: [],
      messagingFailed: false,
      isContact: true,
      oneMessageDetail: {},
      scrollValue: 100,
    };
  },
  async created() {
    this.checkUserLogged();
  },
  methods: {
    handleClickOnDisplayContacts(evt) {
      evt.preventDefault();
        let contactElements = document.querySelectorAll(".contact_button");
        let displayButton = document.querySelector(".contacts-display");
        let hydeButton = document.querySelector(".contacts-hyde");
      if (window.innerWidth < 576) {
        for (let oneButton of contactElements) {
          oneButton.style.display = "initial";
        }
        displayButton.style.display = "none";
        hydeButton.style.display = "initial";
      }
    },
    handleClickOnHydeContacts(evt) {
      evt.preventDefault();
        let contactElements = document.querySelectorAll(".contact_button");
        let displayButton = document.querySelector(".contacts-display");
        let hydeButton = document.querySelector(".contacts-hyde");
      if (window.innerWidth < 576) {
        for (let oneButton of contactElements) {
          oneButton.style.display = "none";
        }
        displayButton.style.display = "initial";
        hydeButton.style.display = "none";
      }
    },
    async checkUserLogged() {
      this.userConnected = await storage.get("data_from_user");
      if (this.userConnected) {
        const currentUserEmail = storage.get("data_from_user").user_email;
        this.senderId = await userService.findUserIdByEmail(currentUserEmail);
        this.loadAllContacts();
      } else {
        this.$router.push("/Login");
      }
      return;
    },
    async loadAllContacts() {
      this.currentRecipient = await userService.findUserById(this.recipientId); //!
      let allRecipientsIdFromMessages = await messageService.loadAllContacts(
        this.senderId
      );
      let recipientIdList = [];
      for (let oneRecipientId of allRecipientsIdFromMessages) {
        if (this.senderId !== parseInt(oneRecipientId.recipient_id)) {
          recipientIdList["recipient" + oneRecipientId.recipient_id] = parseInt(
            oneRecipientId.recipient_id
          );
        }
        if (this.senderId !== parseInt(oneRecipientId.sender_id)) {
          recipientIdList["recipient" + oneRecipientId.sender_id] = parseInt(
            oneRecipientId.sender_id
          );
          this.recipientId = parseInt(oneRecipientId.recipient_id); //!
        }
      }
      for (let onerecipientId in recipientIdList) {
        let recipient = await userService.findUserById(
          recipientIdList[onerecipientId]
        );
        if (recipient) {
          this.recipientsList.push(recipient); //!
        }
      }
      this.findCurrentRecipient();
    },
    async findCurrentRecipient() {
      this.currentRecipient = await userService.findUserById(this.recipientId);
      let selectRecipientMessageElement = document.querySelector(
        "#no_recipient_selected"
      );
      let noUserMessageElement = document.querySelector("#no_user_message");
      let messaginContainerElement = document.querySelector(
        ".user_messagagin-container"
      );
      if (this.currentRecipient) {
        this.currentRecipientName = this.currentRecipient.name;
        selectRecipientMessageElement.style.display = "none";
        noUserMessageElement.style.display = "none";
        this.loadMessageThreads(this.recipientId);
      } else {
        selectRecipientMessageElement.style.display = "none";
        noUserMessageElement.style.display = "flex";
        this.isContact = false;
        messaginContainerElement.style.display = "none";
      }
    },
    async handClickOnRecipientButton(evt) {
      evt.preventDefault();
      this.recipientId = parseInt(evt.currentTarget.dataset.recipientId);
      this.findCurrentRecipient();
    },
    async getMessageThreads(oneMessageTest) {
      let oneMessageObj = {};
      oneMessageObj["id"] = oneMessageTest.id;
      oneMessageObj["content"] = oneMessageTest.content;
      if (oneMessageTest.updated_at !== null) {
        oneMessageObj["date"] = oneMessageTest.updated_at;
      } else {
        oneMessageObj["date"] = oneMessageTest.created_at;
      }
      let dateFiltered = new Date(oneMessageObj["date"]);
      let options = {
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      };
      oneMessageObj["date"] = dateFiltered.toLocaleDateString("fr-FR", options);
      oneMessageObj["senderid"] = parseInt(oneMessageTest.sender_id);
      oneMessageObj["recipientid"] = parseInt(oneMessageTest.recipient_id);
      if (parseInt(oneMessageTest.sender_id) === this.senderId) {
        oneMessageObj["from"] = "sent_message";
        oneMessageObj["name"] = "vous";
      } else {
        oneMessageObj["from"] = "received_message";
        oneMessageObj["name"] = this.currentRecipientName;
      }
      this.allMessageThreads.push(oneMessageObj);
      this.scrollValue += 200;
    },
    async loadMessageThreads(recipientId) {
      this.allMessageThreads = [];
      this.allSenderMessageThreads = await messageService.loadAllMessagesThread(
        this.senderId,
        recipientId
      );
      for (let oneThreads of this.allSenderMessageThreads) {
        this.getMessageThreads(oneThreads);
      }
    },
    async handleSubmitSendMessage(evt) {
      evt.preventDefault();
      if (this.messageContentFromForm !== "") {
        let messageInputElement = evt.target[0];
        let result = await messageService.sendMessage(
          this.senderId,
          this.recipientId,
          this.messageContentFromForm
        );
        if (result) {
          this.loadMessageThreads(this.recipientId);
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
.text_message {
  word-break: break-word;
}
#no_user_message {
  display: none;
}
.messaging {
  flex-grow: 1;
  background-color: $fontColorExtraLight;
}
.archives_contacts {
  display: flex;
  width: 100%;
  background-color: $fontColorMediumLight;
  color: $fontColorMediumDark;
}
.user_to_contact {
  background-color: $various-menus;
  text-align: center;
  padding-bottom: 2rem;
  margin-top: 2rem;
  border-radius: 2rem;
  margin-bottom: 2rem;
}
.archive_messages {
  background-color: $various-menus;
  display: inline;
  text-align: center;
  border-radius: 2rem;
  margin-top: 2rem;
  max-height: 50vh;
  overflow: auto;
    display: flex;
    justify-content: center;
    align-items: center;
  // --------- FIX MOBILE RESPONSIVE -----------------------
  @include x-small {
    margin-top: 0;
  }
  // ------------------------------------------------
}
h1 {
  padding-top: 6rem;
  color: $fontColorDark;
}
h3 {
  color: $fontColorExtraLight;
  padding-top: 1.5rem;
  padding-bottom: 0.3rem;
  font-size: 1.1rem;
}

.received_message {
  width: 70%;
  background-color: $menuClear;
  background-size: cover;
  margin: 1rem;
  border-radius: 0.5rem;
  font-size: 0.8rem;
}

span {
  font-weight: bold;
}
label {
  color: $fontColorExtraLight;
  padding-bottom: 0.5rem;
  font-size: 1.2rem;
}
.sent_message {
  width: 70%;
  background-color: $menuClear;
  background-size: cover;
  margin: 1rem;
  margin-left: 4rem;
  border-radius: 0.5rem;
  font-size: 0.8rem;
}
.users_contact {
  @include screen-large {
    position: fixed;
    width: 40%;
  }
}
.archive_messages {
  @include screen-large {
    position: relative;
    width: 50%;
    left: 50%;
  }
}
.register_form-submit_button {
  padding: 0.5rem;
  border-radius: 0.5rem;
  color: $fontColorExtraLight;
  background-color: $various-menus;
  margin-top: 1rem;
}
.contact_button {
  overflow: hidden;
}
.send_message-button {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0.5rem;
  .send_icon {
  font-size: 2.7rem;
  }
}
// --------- FIX MOBILE RESPONSIVE -----------------------
.form-control {
  @include x-small {
    max-height: 10vh;
  }
}
.user_to_contact {
  @include x-small {
    padding: 0.6rem;
    margin-top: 0;
  }
  h3 {
    @include x-small {
      padding: 0;
    }
  }
}
.contact_button-container {
  .contact_button {
    overflow: hidden;
    @include x-small {
      display: none;
    }
  @include screen-small {
      display: initial;
  }
  }
}
.display_contacts-button {
  @include x-small {
    display: none;
  }
  @include x-small {
    display: initial;
  }
}
.contacts-hyde {
  @include x-small {
    display: none;
  }
  @include screen-small {
    display: none;
  }
}
.contacts-display {
  @include screen-small {
    display: none;
  }
}
// ------------------------------------------------
</style>