<?php

use App\Helpers\ViewHelper;

$page_title = 'Home';
ViewHelper::loadHeader($page_title);

$slides = 6;
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<div id="hero-container" class="page center border-2 div-style-1">

<section id="page-title" class="fancy-title">
    <h1>Moss Cabinet</h1>
</section>

<section id="page-filler" class="flower-divider">
    <p><b>· ·</b> ─────── ·𖥸· ─────── <b>· ·</b></p>
</section>

<section id="best-sellers" class="carousel">
  <ol class="carousel-viewport">
    <?php for ($i = 1; $i <= $slides; $i++):
        $prev = ($i === 1) ? $slides : $i - 1;
        $next = ($i === $slides) ? 1 : $i + 1;
    ?>
      <li id="carousel-slide<?= $i ?>" class="carousel-slide" tabindex="0">
        <div class="carousel"></div>
        <a class="carousel-prev" href="#carousel-slide<?= $prev ?>"></a>
        <a class="carousel-next" href="#carousel-slide<?= $next ?>"></a>
      </li>
    <?php endfor; ?>
  </ol>

  <aside class="carousel-nav">
    <ol class="carousel-nav-list">
      <?php for ($i = 1; $i <= $slides; $i++): ?>
      <li class="carousel-nav-item">
        <a href="#carousel-slide<?= $i ?>" class="carousel-nav-btn"></a>
      </li>
      <?php endfor; ?>
    </ol>
  </aside>
</section>

<section id="featured-user" class="img-container">
    <img src="https://i.pinimg.com/1200x/41/df/ad/41dfad14c853b8b81bdadda0a74e300a.jpg">
</section>

<section id="categories-display" class="cards-container wide">
    <ul>
        <li>cat1</li>
        <li>cat2</li>
        <li>cat3</li>
        <li>cat4</li>
        <li>cat5</li>
        <li>cat6</li>
    </ul>
</section>

<!-- Maybe add another section here to display the latest entries -->

<section id="local-map" class="map-section">
    <h2>Local Witchy Shops</h2>

    <div class="map-wrapper" style="display:flex; gap:20px;position:absolute;left:50%;transform:translate(-50%,0);">

        <div id="store-sidebar" style="width:42rem; max-height:49.75rem; overflow-y:scroll; border:1px solid #ccc; padding:10px; background:#fafafa;">
        </div>

        <div style="flex:1;position:relative;">
            <div id="jewelry-map" style="width:calc(100vw - 42rem - 16rem); height:49.75rem; position:relative; right:0;"></div>
        </div>

    </div>
</section>
</div>

<script>
(() => {
    const viewport = document.querySelector('.carousel-viewport');
    const slides = viewport.children;
    let current = 0;
    const slideCount = slides.length;
    const delay = 60000;

    function goToSlide(index) {
        const slideWidth = viewport.clientWidth;
        viewport.scrollTo({
            left: slideWidth * index,
            behavior: 'smooth'
        });
        current = index;
    }

    function nextSlide() {
        const next = (current + 1) % slideCount;
        goToSlide(next);
    }

    let autoScroll = setInterval(nextSlide, delay);

    viewport.addEventListener('mouseenter', () => clearInterval(autoScroll));
    viewport.addEventListener('mouseleave', () => autoScroll = setInterval(nextSlide, delay));
    viewport.addEventListener('focusin', () => clearInterval(autoScroll));
    viewport.addEventListener('focusout', () => autoScroll = setInterval(nextSlide, delay));

    const dots = document.querySelectorAll('.carousel-navigation-button');
    dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => {
            goToSlide(idx);
            clearInterval(autoScroll);
            autoScroll = setInterval(nextSlide, delay);
        });
    });
})();
</script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
const storeSections = {
  "Crystals & Minerals": [
    {
      name: "Pierres d’Ailleurs",
      desc: "Large selection of crystals, gemstone jewelry, incense and semi-precious stones.",
      address: "4377 Rue Saint-Denis, Montréal, QC H2J 2L2",
      website: "https://www.pierresdailleurs.ca",
      phone: "+1 (514) 849‑9311",
      lat: 45.52326,
      lng: -73.58096
    },
    {
      name: "Crystal Dreams (St-Denis)",
      desc: "Crystal and mineral shop, also sells herbs, oils and magical tools.",
      address: "3803 Rue St-Denis, Montréal, QC",
      website: "https://crystaldreamsworld.com",
      phone: "438-387-6946",
      lat: 45.5330,
      lng: -73.5810
    },
    {
      name: "Maison EmporiOM",
      desc: "Metaphysical store: crystals, cleansing kits, spiritual tools.",
      address: "Montréal, QC (by appointment)",
      website: "https://maisonemporiom.ca",
      phone: null,
      lat: 45.5250,
      lng: -73.5800
    }
  ],

  "Witch Tools & Tarot": [
    {
      name: "Incantations",
      desc: "Occult / metaphysical shop with oils, ritual tools, candles, books.",
      address: "3938 St-Denis, Montréal, QC H2W 2M2",
      website: "https://incantations.ca",
      phone: "+1 (514) 840‑4004",
      lat: 45.5230,
      lng: -73.5830
    },
    {
      name: "Charme & Sortilège",
      desc: "Magick boutique: ritual tools, herbs, candles, ritual jewelry.",
      address: "4933 Rue de Grand-Pré, Montréal, QC H2T 2H9",
      website: "http://charme-et-sortilege.com",
      phone: "+1 (514) 844-8139",
      lat: 45.5370,
      lng: -73.6190
    },
    {
      name: "Ramtha Boutique Ésotérique",
      desc: "Occult supply store: crystals, ritual oils, candles.",
      address: "Québec / Montréal area",
      website: "https://www.ramtha.ca",
      phone: null,
      lat: 45.4500,
      lng: -73.7500
    }
  ],

  "Jewelry & Accessories": [
    {
      name: "Gypsy Star Boutique",
      desc: "Boutique for crystals, artisanal jewelry, candles and oils.",
      address: "Montreal-area (check website for pop-up locations)",
      website: "https://gypsystarboutique.com",
      phone: null,
      lat: 45.5200,
      lng: -73.5700
    },
    {
      name: "Pierres d’Ailleurs", // also sells jewelry
      desc: "Large selection of crystals, gemstone jewelry, incense and semi-precious stones.",
      address: "4377 Rue Saint-Denis, Montréal, QC H2J 2L2",
      website: "https://www.pierresdailleurs.ca",
      phone: "+1 (514) 849‑9311",
      lat: 45.52326,
      lng: -73.58096
    }
  ],

 "Candles & Aromatics": [
    {
      name: "Astor Candles",
      desc: "Custom and religious candles, made locally in Montréal.",
      address: "937 Rue Saint‑Roch, Montréal, QC",
      website: "https://astorcandlesinc.com",
      phone: "(514) 274‑4907",
      lat: 45.5075,
      lng: -73.5666
    },
    {
      name: "Maison L’ATMØSPHERE",
      desc: "Sculptural and decorative artisan candles, inspired by European charm.",
      address: "Montréal, QC",
      website: "https://latmosphere.ca",
      phone: null,
      lat: 45.5200,  
      lng: -73.5750
    },
    {
      name: "Bougie d’Éve",
      desc: "Hand-poured soy candles made in Québec.",
      address: "Québec (Québec-based but ships; check for local stockists)",
      website: "https://bougiedeve.com",
      phone: null,
      lat: 46.8139,  
      lng: -71.2082
    },
    {
      name: "Dans la Prairie",
      desc: "Handmade soy candles crafted in Québec, natural scents, thoughtful design.",
      address: "800 Rue Berri, Montréal, QC",  
      website: "https://danslaprairie.ca",
      phone: null,
      lat: 45.5200, 
      lng: -73.5600
    },
    {
      name: "Les Bougies SM",
      desc: "Soy wax candles made in Québec, cozy and natural fragrances.",
      address: "Québec, QC (manufactured, plus likely local shops / pickup)",
      website: "https://lesbougiessm.com",
      phone: null,
      lat: 46.8139, 
      lng: -71.2082
    }
  ]
};



// Initialize map first
const map = L.map('jewelry-map').setView([45.52, -73.58], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
}).addTo(map);

// Colored icons 
const icons = {
  "Crystals & Minerals": L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
    shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png",
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
  }),
  "Witch Tools & Tarot": L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
    shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png",
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
  }),
  "Jewelry & Accessories": L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png",
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
  }),
  "Candles & Aromatics": L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
    shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png",
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
  })
};

// Add markers safely after map initialization
Object.keys(storeSections).forEach(sectionName => {
  storeSections[sectionName].forEach(store => {
    if(store.lat && store.lng){ 
      L.marker([store.lat, store.lng], { icon: icons[sectionName] })
        .addTo(map)
        .bindPopup(`<b>${store.name}</b><br>${store.desc}<br>${store.address}`);
    }
  });
});

// Sidebar
const sidebar = document.getElementById('store-sidebar');

Object.keys(storeSections).forEach(sectionName => {
  const sectionEl = document.createElement('div');
  sectionEl.style.marginBottom = '20px';

  // Section header
  const header = document.createElement('h3');
  header.textContent = sectionName;
  header.style.borderBottom = '1px solid #ccc';
  header.style.paddingBottom = '5px';
  sectionEl.appendChild(header);

  // Store tabs
  storeSections[sectionName].forEach(store => {
    const tab = document.createElement('div');
    tab.style.border = '1px solid #ddd';
    tab.style.marginTop = '5px';
    tab.style.borderRadius = '5px';
    tab.style.cursor = 'pointer';
    tab.style.overflow = 'hidden';

    // Tab header (store name)
    const tabHeader = document.createElement('div');
    tabHeader.textContent = store.name;
    tabHeader.style.padding = '8px';
    tabHeader.style.fontWeight = 'bold';
    tabHeader.style.background = '#f4f4f4';

    // Tab content
    const tabContent = document.createElement('div');
    tabContent.style.display = 'none';
    tabContent.style.padding = '8px';
    tabContent.innerHTML = `
      <p><b>Category:</b> ${sectionName}</p>
      <p>${store.desc}</p>
      <p><b>Address:</b> ${store.address}</p>
      ${store.website ? `<p><b>Website:</b> <a href="${store.website}" target="_blank">${store.website}</a></p>` : ''}
      ${store.phone ? `<p><b>Phone:</b> <a href="tel:${store.phone.replace(/\s/g,'')}">${store.phone}</a></p>` : ''}
    `;

    // Toggle content on click
    tabHeader.addEventListener('click', () => {
      tabContent.style.display = tabContent.style.display === 'none' ? 'block' : 'none';
      // Pan map to store
      map.setView([store.lat, store.lng], 15, { animate: true });
    });

    tab.appendChild(tabHeader);
    tab.appendChild(tabContent);
    sectionEl.appendChild(tab);
  });

  sidebar.appendChild(sectionEl);
});
</script>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
