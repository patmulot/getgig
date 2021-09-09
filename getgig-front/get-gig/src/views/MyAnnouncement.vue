<template>
  <div class="my_announcement container">
    <h1>Mes Annonces</h1>
    <div class="all_announcement row">
      <div class="inline_announcement col-12 col-md-12 col-lg-6">
        <h2>Mes annonces en cours :</h2>

        <div
          class="my_announcement_content"
          v-for="announcement in userArtistAnnouncements"
          :key="announcement.id"
        >
            <ArtistAnnouncements :mySingleArtistAnnouncement="announcement" />
        </div>

        <div
          class="my_announcement_content"
          v-for="announcement in userOrganizerAnnouncements"
          :key="announcement.id"
        >
          <OrganizerAnnouncements
            :mySingleOrganizerAnnouncement="announcement"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ArtistAnnouncements from "@/components/ArtistAnnouncements.vue";
import OrganizerAnnouncements from "@/components/OrganizerAnnouncements.vue";
import announcementService from "../services/announcementService.js";
import storage from "../plugins/storage.js";
import userService from "../services/userService.js";
export default {
  name: "MyAnnouncement",
  components: {
    ArtistAnnouncements,
    OrganizerAnnouncements,
  },

  async created() {
    // finding user by email :
    const userEmail = await storage.get("data_from_user").user_email;
    const currentUserDatas = await userService.findUserByEmail(userEmail);
    this.currentUserId = currentUserDatas[0].id;
    // -----------------------------------
    // first parameter = author id / second parameter = type id :
    // type id 2 = "artist" and type id 3 = "organizer"
    this.userArtistAnnouncements =
      await announcementService.loadAnnouncementByAuthorAndType(
        this.currentUserId,
        2
      );
    this.userOrganizerAnnouncements =
      await announcementService.loadAnnouncementByAuthorAndType(
        this.currentUserId,
        3
      );
  },

  data() {
    return {
      userArtistAnnouncements: [],
      userOrganizerAnnouncements: [],
      currentUserId: 1, 
    };
  },
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";
// ----------------------------------
// fixes the page height
.container {
  flex-grow: 1;
}
// ----------------------------------
.my_announcement {
  margin-top: 10rem;
}

.all_announcement {
  padding-top: 2rem;
}
</style>