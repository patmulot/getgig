<template>
  <div class="OrganizerAnnouncements">
    <div class="card ms-auto mb-3" >
      <div class="row g-0">
        <div class="col-md-4">
          <img :src="imageUrl" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h4 class="card-title" v-html="title"></h4>
            <h5>Localité : {{ location }}</h5>
            <p>Publié le: {{ date }}</p>
            <p>Début le : {{ startDate }}</p>
            <p>Fin le : {{ endDate }}</p>
            <p class="card-text"></p>
            
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
  name: "OrganizerAnnouncements",

  props: {
    mySingleOrganizerAnnouncement: Object,
  },
  methods: {
    async handleDeleteButton(evt) {
      evt.preventDefault();
    }
  },

  async created() {
    let currentUrl = this.$router.currentRoute.value.path;
    if (currentUrl == "/") {
      this.organizerAnnouncements =
        await announcementService.loadAnnouncementsByType(3);
      this.singleOrganizerAnnouncement = await this.organizerAnnouncements[0];
    } else if (currentUrl == "/MyAnnouncement") {
      this.singleOrganizerAnnouncement = await this
        .mySingleOrganizerAnnouncement;
    }
    // datas :
    this.title = await this.singleOrganizerAnnouncement.title.rendered;
    this.date = await this.singleOrganizerAnnouncement.date;
    this.content = await this.singleOrganizerAnnouncement.content.rendered;
    this.location = await this.singleOrganizerAnnouncement.acf.location;

    this.singleUrl =
      "/single-announcement/" + this.singleOrganizerAnnouncement.id;

    let dateFiltered = new Date(this.singleOrganizerAnnouncement.date);
    let options = {
      year: "numeric",
      month: "long",
      weekday: "long",
      day: "numeric",
    };
    this.date = dateFiltered.toLocaleDateString("fr-FR", options);

    let startDateFiltered = new Date(
      this.singleOrganizerAnnouncement.acf.date_start
    );
    this.startDate = startDateFiltered.toLocaleDateString("fr-FR", options);

    let endDateFiltered = new Date(
      this.singleOrganizerAnnouncement.acf.date_end
    );
    this.endDate = endDateFiltered.toLocaleDateString("fr-FR", options);

    if (this.singleOrganizerAnnouncement._embedded["wp:featuredmedia"]) {
      this.singleOrganizerAnnouncement["imageUrl"] =
        this.singleOrganizerAnnouncement._embedded[
          "wp:featuredmedia"
        ][0].source_url;
      this.imageUrl = this.singleOrganizerAnnouncement["imageUrl"];
    }
  },

  data() {
    return {
      organizerAnnouncements: [],
      singleOrganizerAnnouncement: Object,
      title: "",
      date: "",
      content: "",
      id: 0,
      location: "",
      startDate: "",
      endDate: "",
      imageUrl: "https://i.ibb.co/3mq8TfX/default-image.jpg",
      singleUrl: "",
      // ---------  DYNAMIC DISPLAY HOME ----------------------------
      organizerAnnouncementIdToLoad: 0,
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

.link-style {
  color: $fontColorMediumLight;
  text-decoration: underline;
}
.link-style:hover {
  color: $fontColorMediumDark;
  cursor: pointer;
}
</style>