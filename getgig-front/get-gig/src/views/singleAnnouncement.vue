<template>
  <div class="artistAnnouncements container">
    <div class="announcement_type-container">
      <h1>Annonce {{ this.type }}</h1>
      <div class="type_icon-container">
        <i class="fas fa-music" v-if="this.typeArtist"></i>
        <i class="fas fa-icons" v-if="this.typeOrganizer"></i>
      </div>
    </div>

    <div class="row container_single">
      <div class="announcement_image-container col-12 col-lg-5 my-auto">
        <img class="announcement_image" :src="imageUrl" alt="..." />
      </div>

      <div
        class="announcement_content-container text-start col-12 col-lg-5 p-3"
      >
        <div class="announcement_content-container_title">
          <h4 v-html="this.allAnnouncementsTab.title.rendered"></h4>
        </div>
        <div class="announcement_content-container_date">
          <p>Du : {{ startDate }}</p>
          <p>Au : {{ endDate }}</p>
          <p>A {{ this.allAnnouncementsTab.acf.location }}</p>
        </div>

        <div class="announcement_content-container_text">
          <p
            class="card-text text-start col-12"
            v-html="this.allAnnouncementsTab.content.rendered"
          ></p>
          <p>Publié le : {{ this.date }} par {{ this.author }}</p>
        </div>
      </div>

      <div class="announcement_contact-container col-12 col-lg-2 my-auto">
        <router-link class="announcement_contact" :to="currentUrl"
          >Contactez l'auteur de l'annonce !</router-link
        >
      </div>
    </div>
  </div>
</template>

<script>
import announcementService from "../services/announcementService.js";
import userService from "../services/userService.js";
export default {
  name: "singleAnnouncement",
  data() {
    return {
      allAnnouncementsTab: [],
      currentUrl: "",
      currentAnnouncementId: 155,
      type: "no type",
      typeOrganizer: false,
      typeArtist: false,
      author: "no author", //! author id : this.allAnnouncementsTab.author
      imageUrl: "https://i.ibb.co/3mq8TfX/default-image.jpg",
      date: "date non filtrée", //! this.allAnnouncementsTab.date
      startDate: "",
      endDate: "",
    };
  },
  async created() {
    this.currentAnnouncementId = parseInt(this.$route.params.id);
    this.allAnnouncementsTab = await announcementService.loadAnnouncementById(
      this.currentAnnouncementId
    );
    this.currentUrl = "/Contact/" + this.allAnnouncementsTab.author;
    // formating date from data :
    let dateFiltered = new Date(this.allAnnouncementsTab.date);
    let options = {
      year: "numeric",
      month: "long",
      weekday: "long",
      day: "numeric",
    };
    this.date = dateFiltered.toLocaleDateString("fr-FR", options);

    let startDateFiltered = new Date(this.allAnnouncementsTab.acf.date_start);
    this.startDate = startDateFiltered.toLocaleDateString("fr-FR", options);

    let endDateFiltered = new Date(this.allAnnouncementsTab.acf.date_end);
    this.endDate = endDateFiltered.toLocaleDateString("fr-FR", options);

    // formating type from data :
    if (this.allAnnouncementsTab.Type == 2) {
      this.type = "Artiste";
      this.typeArtist = true;
    } else if (this.allAnnouncementsTab.Type == 3) {
      this.typeOrganizer = true;
      this.type = "Organisateur";
    }
    // formating author from data id :
    const currentAuthor = await userService.findUserById(
      parseInt(this.allAnnouncementsTab.author)
    );
    this.author = currentAuthor.name;
    // getting image url :
    if (this.allAnnouncementsTab._embedded["wp:featuredmedia"]) {
      this.imageUrl =
        this.allAnnouncementsTab._embedded["wp:featuredmedia"][0].source_url; 
    } else {
      this.imageUrl = "https://i.ibb.co/3mq8TfX/default-image.jpg"; 
    }
  },
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";

.artistAnnouncements {
  text-align: center;
  margin-top: 12rem;
  // fixes the page height
  flex-grow: 1;
  margin-bottom: 3rem;
  .announcement_type-container {
    display: flex;
    justify-content: space-between;
    color: $various-text;
    h1 {
      color: $various-text;
    }

    .type_icon-container {
      font-size: 2rem;
    }
  }

  .announcement_content-container {
    h4 {
      font-size: 2rem;
      border-bottom: black 1px solid;
    }
    p {
      margin: 0;
    }

    .announcement_content-container_date {
      border-bottom: black 1px solid;
    }

    .announcement_content-container_text {
      margin-top: 1rem;
      border-bottom: black 1px solid;
    }
  }

  .card-text {
  word-break: break-word;
  }

  .announcement_image {
    width: 100%;
    height: auto;
  }

  .announcement_contact-container:hover {
    transform: scale(1.1);
    border-bottom: black 1px solid;
  }
  .announcement_contact-container {
    background-color: $various-menus;
    padding: 1rem;
    border-radius: 1rem;
    box-shadow: 2px 2px 10px grey;

    .announcement_contact {
      color: $fontColorExtraLight;
      text-decoration: none;
    }
  }
}

.container_single {
  background-color: $fontColorExtraLight;
}

</style>