<template>
  <div>
    <div class="about container">
      <p class="heading-text ms-2 mb-3 text-start col-12 fs-5">
        <em
          >Organisateurs d'évènements musicaux et Artistes, ce site est fait
          pour vous rencontrer</em
        >
      </p>
      <div class="about_avatar row mb-3">
        <div class="box box-1 col-3 box_anca">
          <div class="cover">
            <img
              src="../assets/images/avatars-devs/Anca.jpg"
              class="col-12 col-lg-8 rounded-circle"
              alt=""
            />
            <h4 class="text-center">Anca</h4>
            <span class="dev_anca">devloper front / scrum master</span>
          </div>
        </div>

       <div class="box box-1 col-3 box_tomy">
          <div class="cover">
            <img
              src="../assets/images/avatars-devs/Tomy.jpg"
              class="col-12 col-lg-8 rounded-circle"
              alt=""
            />
            <h4 class="text-center">Tomy</h4>
            <span class="dev_tomy">lead devloper front / git master</span>
          </div>
        </div>

       <div class="box box-1 col-3 box_ludo">
          <div class="cover">
            <img
              src="../assets/images/avatars-devs/Ludo.jpg"
              class="col-12 col-lg-8 rounded-circle"
              alt=""
            />
            <h4 class="text-center">Ludo</h4>
            <span class="dev_ludo">lead devloper back</span>
          </div>
        </div>

       <div class="box box-1 col-3 box_pat">
          <div class="cover">
            <img
              src="../assets/images/avatars-devs/Pat.jpg"
              class="col-12 col-lg-8 rounded-circle"
              alt=""
            />
            <h4 class="text-center">Pat</h4>
            <span class="dev_pat">dev back / product owner</span>
          </div>
        </div>
      </div>

      <div class="about_text ms-2 text-start col-12 fs-6">
        <p>
          En ces heures sombres, où musiciens et organisateurs ont de plus en
          plus de difficultés à se trouver en dehors des réseaux "mainstream” et
          des grosses sociétés de production, nous mettons à disposition une
          solution afin de faciliter la connectivité entre les différents
          acteurs de l'événement musical.
        </p>
        <p class="fontColorMediumLight fs-4">Les développeurs</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "About",
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";

p {
  color: $fontColorDark;
}

.fontColorMediumLight {
  font-size: 1.1rem;
  color: $fontColorMediumLight;
}
h4 {
  color: $fontColorMediumLight;
}

.about_avatar {
  select {
    margin: 0;
    padding: 0;
  }
  
  .container {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: distribute;
    justify-content: space-around;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    width: 80vw;
    height: 100vh;
    margin-left: 6vw;
  }

  .box {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
    will-change: transform;
  }

  .box:hover .cover {
    -webkit-transform: translateY(-14px) scale(1.1);
    transform: translateY(-14px) scale(1.1);
  }

  .box-1 button {
    border: 1px solid $various-menus;
    color: #fff;
    font-size: 22px;
    text-align: right;
    padding-right: 20px;
    line-height: 40px;
  }

  .box-1 button::after {
    content: "";
    background-color: $various-menus;
    top: -85px;
  }

  .cover {
    -webkit-transition: all 400ms ease-in-out;
    transition: all 400ms ease-in-out;
    will-change: transform;
  }

  .cover img {
    -webkit-transition: all 260ms ease-in-out;
    transition: all 260ms ease-in-out;
  }

  .box .cover::after {
    content: "";
    z-index: -99;
    position: absolute;
    top: 20px;
    left: -20px;
    display: block;
    height: 160px;
    opacity: 0;
    background-position: center;
    background-repeat: no-repeat;
    background-size: 160px 214px;
    -webkit-filter: blur(24px);
    filter: blur(24px);
    -webkit-transition: all 260ms ease-in-out;
    transition: all 260ms ease-in-out;
    will-change: transform;
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  .box:hover .cover::after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  

  .box-1 button div::before {
    content: "Sensebot";
    position: relative;
    top: -44px;
    left: -4px;
    color: $various-menus;
    font-size: 21px;
    font-weight: 300;
  }

  .box-1:hover button div::before {
    color: #fff;
  }


  .dev_anca,
  .dev_ludo,
  .dev_pat,
  .dev_tomy {
    display: flex;
    justify-content: center;
    transition-duration: 500ms;
    color: #2e2d2d00;
    text-align: center;
    font-size: 0.6rem;
  }
  .box_anca:hover {
    .dev_anca {
      color: #2E2D2D;
    }
  }
  .box_pat:hover {
    .dev_pat {
      color: #2E2D2D;
    }
  }
  .box_ludo:hover {
    .dev_ludo {
      color: #2E2D2D;
    }
  }
  .box_tomy:hover {
    .dev_tomy {
      color: #2E2D2D;
    }
  }
}
</style>