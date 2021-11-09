<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */
get_header();
?>

<head>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/custom.css">
</head>

    <section id="primary" class="content-area">
    <main id="main" class="site-main">

    <nav id="argang-filtrering"><button class="filter valgt" data-argang="alle">Alle</button></nav>
    <nav id="kategori-filtrering"><button class="filter valgt" data-cat="alle">Alle</button></nav>
        <h1 id="temaer">Temaer for kurser</h1>
        <section id="kursus-oversigt"></section>
    </main>


    <template>
      <article>
        <img src="" alt="" />
        <div>
        <h2></h2>
        <p class="fag"></p>
        <p class="beskrivelse"></p>
        </div>
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
                document.querySelector("#kategori-filtrering").innerHTML += `<button class="filter" data-cat="${cat.id}">${cat.name}</button>`
                }
            })
                argang.forEach(argang=>{
               //console.log(argang.id);
                document.querySelector("#argang-filtrering").innerHTML += `<button class="filter" data-argang="${argang.id}">${argang.name}</button>`
             
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
                    klon.querySelector("h2").textContent = kursus.title.rendered;
                    klon.querySelector("img").src = kursus.billede.guid;
                    klon.querySelector(".fag").textContent = kursus.fag;
                    klon.querySelector(".beskrivelse").textContent = kursus.beskrivelse;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = kursus.link;
                    })
                    liste.appendChild(klon);
                }
            })

        }

        function addEventListenersToButtons() {
            document.querySelectorAll("#kategori-filtrering button").forEach(elm => {
                elm.addEventListener("click", filtreringKategori);
            })
             document.querySelectorAll("#argang-filtrering button").forEach(elm => {
                elm.addEventListener("click", filtreringArgang);
            })
        }

        function filtreringKategori() {
            filterKursus = this.dataset.cat;
            document.querySelector("h1").textContent = this.textContent;
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
            document.querySelector("h1").textContent = this.textContent;
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

