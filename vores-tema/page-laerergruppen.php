<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package OceanWP WordPress theme
 */
get_header();
?>

    <section id="primary" class="content-area">
    <main id="main" class="site-main">

    <?php
				// Elementor `single` location.
				if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {

					// Start loop.
					while ( have_posts() ) :
						the_post();

						get_template_part( 'partials/page/layout' );

					endwhile;

				}
				?>

<div class="dropdown">
  <button class="dropbtn-argang">Årgang ↓</button>
    <nav class="dropdown-content" id="argang-filtrering"><div class="filter valgt" data-argang="alle">Alle</div></nav>
    </div>

    <div class="dropdown">
  <button class="dropbtn">Tema ↓</button>
    <nav class="dropdown-content" id="kategori-filtrering"><div class="filter valgt" data-cat="alle">Alle</div></nav>
    </div>
        <section id="kursus-oversigt"></section>
       
    </main>

    <template>
      <article id="artikel">
        <img src="" alt="" />
        <div>
        <h2 class="titel"></h2>
        <p class="beskrivelse"></p>
        </div>
        <button class="kursusknap">Læs mere</button>
        </article>
    </template>

        <script>

        const siteUrl = "<?php echo esc_url( home_url( '/' ) ); ?>";
        let kurser = [];
        let categories = [];
        let argang = [];
        const liste = document.querySelector("#kursus-oversigt");
        const skabelon = document.querySelector("template");
        let filterKursus = "alle";
        let filterArgang = "alle";

        document.addEventListener("DOMContentLoaded", start);

        function start() {
            console.log("id er", <?php echo get_the_ID() ?>);
            console.log(siteUrl);
            
            getJson();
        }

        async function getJson() {
            //hent alle custom posttypes retter
            const url = siteUrl +"wp-json/wp/v2/kursus?per_page=100";
            //hent basis categories
            const catUrl = "https://oliviabang.dk/kea/09_CMS/ungdomsbyen/wordpress/wp-json/wp/v2/categories";
             //hent custom category: argang
            const contUrl = "https://oliviabang.dk/kea/09_CMS/ungdomsbyen/wordpress/wp-json/wp/v2/argang";
            let response = await fetch(url);
            let catResponse = await fetch(catUrl);
            let argangResponse = await fetch(contUrl);
            kurser = await response.json();
            categories = await catResponse.json();
            argang = await argangResponse.json();
            visKurser();
            opretKnapper();
        }

        function opretKnapper(){
            
            categories.forEach(cat=>{
               //console.log(cat.id);

                if(cat.name != "Uncategorized"){
                document.querySelector("#kategori-filtrering").innerHTML += `<div class="filter" data-cat="${cat.id}">${cat.name}</div>`
                }
            })
                argang.forEach(argang=>{
               //console.log(argang.id);
                document.querySelector("#argang-filtrering").innerHTML += `<div class="filter" data-argang="${argang.id}">${argang.name}</div>`
            })
            addEventListenersToButtons();
        }

        function visKurser() {
            console.log(kurser);
            liste.innerHTML = "";
            console.log({filterKursus});
            console.log({filterArgang});
            kurser.forEach(kursus => {
                //tjek filterKursus og filterArgang til filtrering
                if ((filterKursus == "alle"  || kursus.categories.includes(parseInt(filterKursus))) && (filterArgang == "alle"  || kursus.argang.includes(parseInt(filterArgang)))) {
                    const klon = skabelon.cloneNode(true).content;
                    klon.querySelector(".titel").textContent = kursus.title.rendered;
                    klon.querySelector("img").src = kursus.billede.guid;
                    klon.querySelector(".beskrivelse").textContent = kursus.beskrivelse;
                    klon.querySelector(".kursusknap").textContent = kursus.knap;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = kursus.link;
                    })
                    liste.appendChild(klon);
                } else{
                    console.log("der er ingen kurser");
                }
            })

        }

        function addEventListenersToButtons() {
            document.querySelectorAll("#kategori-filtrering div").forEach(elm => {
                elm.addEventListener("click", filtreringKategori);
            })
             document.querySelectorAll("#argang-filtrering div").forEach(elm => {
                elm.addEventListener("click", filtreringArgang);
            })
        }

      function filtreringKategori() {
            filterKursus = this.dataset.cat;
            //fjern .valgt fra alle
            document.querySelectorAll("#kategori-filtrering .filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
            //tilføj .valgt til den valgte
            this.classList.add("valgt");
            visKurser();
        }

        function filtreringArgang() {
            filterArgang = this.dataset.argang;
             //fjern .valgt fra alle
            document.querySelectorAll("#argang-filtrering .filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
            //tilføj .valgt til den valgte
            this.classList.add("valgt");
            visKurser();
        }

        </script>

		
	</section><!-- #primary -->

<?php
get_footer();

