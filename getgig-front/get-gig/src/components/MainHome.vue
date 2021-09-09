 <template>
  <div class="MainHome">
    <div id="background-wrap">
      <div class="bubble x1"><i class="fab fa-itunes-note"></i></div>
      <div class="bubble x2"><i class="fas fa-drum"></i></div>
      <div class="bubble x3">
        <img
          src="https://freepikpsd.com/media/2019/10/dessin-guitare-png-2-Transparent-Images.png"
          alt=""
        />
      </div>
      <div class="bubble x4">
        <img
          src="https://i.pinimg.com/originals/dd/5a/45/dd5a452df452930ff3407087f5f6465d.png"
          alt=""
        />
      </div>
      <div class="bubble x5"><i class="fab fa-itunes-note"></i></div>
      <div class="bubble x6">
        <img
          src="https://i.pinimg.com/originals/dd/5a/45/dd5a452df452930ff3407087f5f6465d.png"
          alt=""
        />
      </div>
      <div class="bubble x7">
        <img
          src="https://freepikpsd.com/media/2019/10/dessin-guitare-png-2-Transparent-Images.png"
          alt=""
        />
      </div>
      <div class="bubble x8"><i class="fab fa-itunes-note"></i></div>

      <div class="bubble x10"><i class="fas fa-drum"></i></div>
    </div>
    <div class="home_page">
      <h1 class="font_1">GetGig</h1>
      <!-- <h1 class="font_1">
        <span class="dance">G</span><span class="dance">e</span
        ><span class="dance">t</span><span class="dance">G</span
        ><span class="dance">i</span><span class="dance">g</span>
      </h1> -->
      <p>que la musique soit !</p>
    </div>
    <div class="scroll_down_button" @click="handleClickOnScreenScroll">
      <i class="fas fa-chevron-circle-down scroll_down_button-icon"></i>
    </div>
  </div>
</template>

<script>
export default {
  name: "MainHome",
  methods: {
    handleClickOnScreenScroll(evt) {
      evt.preventDefault();
      let screenHomeElement = document.querySelector(".MainHome");
      window.scroll(0, screenHomeElement.clientHeight - 48);
    },
  }
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";
.font_1 {
  font-family: "Fredericka the Great", cursive;
  font-family: 'New Rocker', cursive;
  font-family: 'Mansalva', cursive;
  font-weight: bolder;
  font-size: 5.4rem;
}
.home_page {
  text-shadow: 0px 0px 20px $fontColorExtraLight, 0 0 1px black;
}
// h1 {
//   // text-shadow: 0px 0px 0px rgb(160, 244, 255);
//   // transition-duration: 1000ms;
//   span {
//     text-shadow: 0px 0px 0px rgba(178, 252, 255, 0.8);
//     transition-duration: 1000ms;
//   }
//   span:hover {
//     transform: scale(0.9);
//     text-shadow: 0px 0px 200px white;
//   }
// }
// h1:hover {
//   text-shadow: 0px 0px 200px white;
// }

.MainHome {
  position: relative;
  color: $fontColorDark;
  text-align: center;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;

  background-image: url("../assets/home-header.jpg");
  background-size: cover;
  background-repeat: no-repeat;

  #background-wrap {
    color: black;
    opacity: 0.6;
    width: 100vw;
    overflow: hidden;

    /* KEYFRAMES */

    @-webkit-keyframes animateBubble {
      0% {
        margin-top: 800px;
      }
      100% {
        margin-top: -100%;
      }
    }

    @-moz-keyframes animateBubble {
      0% {
        margin-top: 800px;
      }
      100% {
        margin-top: -100%;
      }
    }

    @keyframes animateBubble {
      0% {
        margin-top: 250px;
      }
      100% {
        margin-top: -100%;
      }
    }

    @-webkit-keyframes sideWays {
      0% {
        margin-left: 0px;
      }
      100% {
        margin-left: 50px;
      }
    }

    @-moz-keyframes sideWays {
      0% {
        margin-left: 0px;
      }
      100% {
        margin-left: 50px;
      }
    }

    @keyframes sideWays {
      0% {
        margin-left: 0px;
      }
      100% {
        margin-left: 50px;
      }
    }

    /* ANIMATIONS */

    .x1 {
      -webkit-animation: animateBubble 14s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      -moz-animation: animateBubble 14s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      animation: animateBubble 14s linear infinite,
        sideWays 2s ease-in-out infinite alternate;

      left: 2%;

      -webkit-transform: scale(0.6);
      -moz-transform: scale(0.6);
      transform: scale(0.6);
    }

    .x2 {
      -webkit-animation: animateBubble 12s linear infinite,
        sideWays 4s ease-in-out infinite alternate;
      -moz-animation: animateBubble 12s linear infinite,
        sideWays 4s ease-in-out infinite alternate;
      animation: animateBubble 12s linear infinite,
        sideWays 4s ease-in-out infinite alternate;

      left: 5%;

      -webkit-transform: scale(0.4);
      -moz-transform: scale(0.4);
      transform: scale(0.4);
    }

    .x3 {
      -webkit-animation: animateBubble 10s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      -moz-animation: animateBubble 10s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      animation: animateBubble 10s linear infinite,
        sideWays 2s ease-in-out infinite alternate;

      left: 10%;

      -webkit-transform: scale(0.7);
      -moz-transform: scale(0.7);
      transform: scale(0.7);
    }

    .x4 {
      -webkit-animation: animateBubble 8s linear infinite,
        sideWays 3s ease-in-out infinite alternate;
      -moz-animation: animateBubble 8s linear infinite,
        sideWays 3s ease-in-out infinite alternate;
      animation: animateBubble 8s linear infinite,
        sideWays 3s ease-in-out infinite alternate;

      left: 20%;

      -webkit-transform: scale(0.3);
      -moz-transform: scale(0.3);
      transform: scale(0.3);
    }

    .x5 {
      -webkit-animation: animateBubble 6s linear infinite,
        sideWays 4s ease-in-out infinite alternate;
      -moz-animation: animateBubble 6s linear infinite,
        sideWays 4s ease-in-out infinite alternate;
      animation: animateBubble 6s linear infinite,
        sideWays 4s ease-in-out infinite alternate;

      left: 30%;

      -webkit-transform: scale(0.5);
      -moz-transform: scale(0.5);
      transform: scale(0.5);
    }

    .x6 {
      -webkit-animation: animateBubble 14s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      -moz-animation: animateBubble 14s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      animation: animateBubble 14s linear infinite,
        sideWays 2s ease-in-out infinite alternate;

      left: 20%;

      -webkit-transform: scale(0.8);
      -moz-transform: scale(0.8);
      transform: scale(0.8);
    }

    .x7 {
      -webkit-animation: animateBubble 12s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      -moz-animation: animateBubble 12s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      animation: animateBubble 12s linear infinite,
        sideWays 2s ease-in-out infinite alternate;

      left: 50%;

      -webkit-transform: scale(0.4);
      -moz-transform: scale(0.4);
      transform: scale(0.4);
    }

    .x8 {
      -webkit-animation: animateBubble 10s linear infinite,
        sideWays 3s ease-in-out infinite alternate;
      -moz-animation: animateBubble 10s linear infinite,
        sideWays 3s ease-in-out infinite alternate;
      animation: animateBubble 10s linear infinite,
        sideWays 3s ease-in-out infinite alternate;

      left: 55%;

      -webkit-transform: scale(0.3);
      -moz-transform: scale(0.3);
      transform: scale(0.3);
    }

    .x9 {
      -webkit-animation: animateBubble 8s linear infinite,
        sideWays 4s ease-in-out infinite alternate;
      -moz-animation: animateBubble 8s linear infinite,
        sideWays 4s ease-in-out infinite alternate;
      animation: animateBubble 8s linear infinite,
        sideWays 4s ease-in-out infinite alternate;

      left: 55%;

      -webkit-transform: scale(0.6);
      -moz-transform: scale(0.6);
      transform: scale(0.6);
    }

    .x10 {
      -webkit-animation: animateBubble 6s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      -moz-animation: animateBubble 6s linear infinite,
        sideWays 2s ease-in-out infinite alternate;
      animation: animateBubble 6s linear infinite,
        sideWays 2s ease-in-out infinite alternate;

      left: 50%;

      -webkit-transform: scale(0.3);
      -moz-transform: scale(0.3);
      transform: scale(0.3);
    }

    /* OBJECTS */

    .bubble {
      -webkit-border-radius: 50%;
      -moz-border-radius: 50%;
      border-radius: 50%;
      position: absolute;
      font-size: 10rem;

      img {
        width: 10rem;
        height: auto;
      }
    }
  }
  .scroll_down_button {
    position: absolute;
    height: 3rem;
    width: 3rem;
    left: calc(50% - 1.5rem);
    bottom: 10rem;
    transition-duration: 300ms;
    border-radius: 50%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  .scroll_down_button-icon {
    height: 100%;
    width: 100%;
  }
  }
  .scroll_down_button:hover {
    cursor: pointer;
    transform: scale(0.9);
    box-shadow: 0 0 50px white;
    color: $fontColorMediumDark
  }
}

.MainHome p {
  font-size: 2rem;
  padding-right: 8rem;
  padding-left: 8rem;
  font-weight: bolder;
}
h1 {
  font-size: 5rem;
}
</style>