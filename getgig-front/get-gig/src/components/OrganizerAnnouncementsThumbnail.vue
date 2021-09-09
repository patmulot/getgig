<template>
  <div class="OrganizerAnnouncements">
    <div class="card mb-3" style="max-width: 1450px">
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
            <p class="card-text" v-html="excerpt"></p>
            <p class="card-text">
              <small class="text-muted">contact via le site</small>
            </p>

            <div class="single-page nav-link col-12">
              <router-link :to="singleUrl" class="single-page nav-link col-6"
                >Details de l'annonce</router-link
              >
            </div>
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
    this.excerpt = await this.singleOrganizerAnnouncement.excerpt.rendered;
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
      excerpt: "",
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

.single-page {
  color: $fontColorMediumLight;
  text-decoration: underline;
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