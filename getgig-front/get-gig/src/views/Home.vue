<template>
  <div class="home main_container">
    <MainHome/>

    <div class="alert alert-danger" role="alert" v-if="isUserConnected">
      Bienvenue, {{ this.usernameFromForm }}
    </div>

    <h3 class="display-4 text-center mt-5 mb-5">A propos</h3>
    <About />
    <h2 class="display-5 text-center mt-5 mb-4">
      <router-link to="/announcements">Dernières Annonces</router-link>
    </h2>
    <LastAnnouncements v-on:single-announcement-to-load="getAnnouncementById" />
    <div class="artist_announcement" id="artist">
      <h2 class="display-5 text-center mt-5 mb-4">
        <router-link to="/announcements">Annonces Artistes</router-link>
      </h2>
      <ArtistAnnouncementsThumbnail v-if="previousArtistAnn" />
      <allAnnouncementsThumbnail
        v-if="isArtistAnnClicked"
        :announcement="artistAnnouncement"
      />
    </div>
    <div class="artist_announcement" id="organizer">
      <h2 class="display-5 text-center mt-5 mb-4">
        <router-link to="/announcements">Annonces Organisateurs</router-link>
      </h2>
      <OrganizerAnnouncementsThumbnail v-if="previousOrganizerAnn" />
      <allAnnouncementsThumbnail
        v-if="isOrganizerAnnClicked"
        :announcement="organizerAnnouncement"
      />
    </div>
  </div>
</template>

<script>
import MainHome from "@/components/MainHome.vue";
import About from "@/components/About.vue";
import LastAnnouncements from "@/components/LastAnnouncements.vue";
import ArtistAnnouncementsThumbnail from "@/components/ArtistAnnouncementsThumbnail.vue";
import OrganizerAnnouncementsThumbnail from "@/components/OrganizerAnnouncementsThumbnail.vue";
import allAnnouncementsThumbnail from "@/components/allAnnouncementsThumbnail.vue";
import announcementService from "../services/announcementService";

export default {
  name: "Home",
  components: {
    MainHome,
    About,
    LastAnnouncements,
    ArtistAnnouncementsThumbnail,
    OrganizerAnnouncementsThumbnail,
    allAnnouncementsThumbnail,
  },
  // ---------  DYNAMIC DISPLAY HOME ----------------------------
  data() {
    return {
      isArtistAnnClicked: false,
      isOrganizerAnnClicked: false,
      previousArtistAnn: true,
      previousOrganizerAnn: true,
      artistAnnouncement: Object,
      organizerAnnouncement: Object,
      isUserConnected: false,
    };
  },
  methods: {
    async getAnnouncementById(announcementData) {
      this.isArtistAnnClicked = false;
      this.isOrganizerAnnClicked = false;
      this.previousArtistAnn = true;
      this.previousOrganizerAnn = true;
      let announcementToLoad = {};
      if (announcementData[1] === 2) {
        announcementToLoad = await announcementService.loadAnnouncementById(
          announcementData[0]
        );
        this.isArtistAnnClicked = false;
        this.previousArtistAnn = false;
        this.isArtistAnnClicked = true;
        this.artistAnnouncement = announcementToLoad;
      } else if (announcementData[1] === 3) {
        announcementToLoad = await announcementService.loadAnnouncementById(
          announcementData[0]
        );
        this.isOrganizerAnnClicked = false;
        this.previousOrganizerAnn = false;
        this.isOrganizerAnnClicked = true;
        this.organizerAnnouncement = announcementToLoad;
      }
    },
  },
  // ---------------------------------------------------------
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";
.main_container {
  flex-grow: 1;
}
.home {
  width: 100%;
}

a {
  color: $various-text;
  text-decoration: none;
}

h3 {
  color: $various-text;
  padding-top: 1rem;
  font-weight: strong;
}

.alert-danger {
  font-size: 1rem;
}
</style>