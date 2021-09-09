<template>
  <div class="artistAnnouncements">
    <div class="card mb-3" >
      <div class="row ">
        <div class="col-md-4">
          <img :src="imageUrl" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h4 class="card-title" v-html="title"></h4>
            <h5>Localité : {{ location }}</h5>
            <p>Publié le : {{ date }}</p>
            <p>Début le : {{ startDate }}</p>
            <p>Fin le : {{ endDate }}</p>
            
            <router-link :to="singleUrl" class="single-page nav-link col-12"
              >Details de l'annonce</router-link
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import announcementService from "../services/announcementService.js";
export default {
  name: "ArtistAnnouncements",
  methods: {
    async handleDeleteButton(evt) {
      evt.preventDefault();
      this.deleteAnnouncement();
    },

    async deleteAnnouncement() {
      const result = await announcementService.deleteAnnouncement(this.id);
      if (result) {
       this.$router.push("Messages");
        return result;
      } else {
        this.deleteFail = true;
      }
    },
  },
  props: {
    mySingleArtistAnnouncement: Object,
  },
  async created() {
    let currentUrl = this.$router.currentRoute.value.path;
    if (currentUrl == "/") {
      this.artistAnnouncements =
        await announcementService.loadAnnouncementsByType(2);
      this.singleArtistAnnouncement = await this.artistAnnouncements[0];
    } else if (currentUrl == "/MyAnnouncement") {
      this.singleArtistAnnouncement = await this.mySingleArtistAnnouncement;
    }

    // datas :
    this.singleUrl = "/single-announcement/" + this.singleArtistAnnouncement.id;
    this.title = await this.singleArtistAnnouncement.title.rendered;
    this.date = await this.singleArtistAnnouncement.date;
    this.content = await this.singleArtistAnnouncement.content.rendered;
    this.id = this.singleArtistAnnouncement.id;
    this.location = await this.singleArtistAnnouncement.acf.location;
    this.startDate = await this.singleArtistAnnouncement.acf.date_start;
    this.endDate = await this.singleArtistAnnouncement.acf.date_end;

    let dateFiltered = new Date(this.singleArtistAnnouncement.date);
    let options = {
      year: "numeric",
      month: "long",
      weekday: "long",
      day: "numeric",
    };
    this.date = dateFiltered.toLocaleDateString("fr-FR", options);

    let startDateFiltered = new Date(
      this.singleArtistAnnouncement.acf.date_start
    );
    this.startDate = startDateFiltered.toLocaleDateString("fr-FR", options);

    let endDateFiltered = new Date(this.singleArtistAnnouncement.acf.date_end);
    this.endDate = endDateFiltered.toLocaleDateString("fr-FR", options);

    if (this.singleArtistAnnouncement._embedded["wp:featuredmedia"]) {
      this.singleArtistAnnouncement["imageUrl"] =
        this.singleArtistAnnouncement._embedded[
          "wp:featuredmedia"
        ][0].source_url;
      this.imageUrl = this.singleArtistAnnouncement["imageUrl"];
    }
  },
  data() {
    return {
      artistAnnouncements: [],
      singleArtistAnnouncement: Object,
      isMyAnnouncement: false,
      title: "",
      date: "",
      content: "",
      id: 0,
      location: "",
      startDate: "",
      endDate: "",
      imageUrl: "https://i.ibb.co/3mq8TfX/default-image.jpg", 
      singleUrl: "",
      deleteFail: false,
      // --------- DYNAMIC DISPLAY HOME ------------------
      announcementClickedFromThumbnailId: Object,
      artistAnnouncementIdToLoad: 0,
      // -----------------------------------------------
    };
  },
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";


a{
  color: $various-text;
  text-decoration: underline;
  font-size: 1.2rem;;
}
.card-title{
  color: $various-text;
}
h5{
  margin-bottom:2rem;
}
.link-style:hover {
  color: $fontColorMediumDark;
  cursor: pointer;
}
</style>
