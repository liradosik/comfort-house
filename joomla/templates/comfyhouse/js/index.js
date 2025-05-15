document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector(".header");
  const headerScroll = document.querySelector(".header__scroll");
  const headerHeight = 196; // Высота хедера в пикселях

  window.addEventListener("scroll", function () {
    if (window.scrollY > headerHeight) {
      headerScroll.classList.remove("visually-hidden");
    } else {
      headerScroll.classList.add("visually-hidden");
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const heroImage = document.querySelector(".hero__image");

  // Начальное значение bottom
  const initialBottom = -10; // Начинаем с -50% высоты изображения

  window.addEventListener("scroll", function () {
    const scrollY = window.scrollY;

    // Максимальное значение, на которое можно поднять изображение
    const maxScroll = 35; // Измените это значение в зависимости от желаемого подъема

    // Вычисляем новое значение bottom для изображения
    const newBottom = Math.min(initialBottom + scrollY / 10, maxScroll); // Делим на 5 для замедления подъема

    // Устанавливаем новое значение bottom
    heroImage.style.bottom = `${newBottom}%`;
  });
});

// Получаем все элементы с классом location__pins
const pins = document.querySelectorAll(".location__pins");

pins.forEach((pin) => {
  const block = pin.querySelector(".location__block");
  const svg = pin.querySelector("svg");
  const path = pin.querySelector("path");

  pin.addEventListener("mouseenter", () => {
    pin.classList.add("location__pins--active"); // Добавляем класс к родительскому элементу
    block.classList.remove("visually-hidden"); // Убираем класс visually-hidden
    svg.classList.add("location__pin--active"); // Добавляем класс к svg
    path.classList.add("location__pin--active"); // Добавляем класс к path
  });

  pin.addEventListener("mouseleave", () => {
    pin.classList.remove("location__pins--active"); // Убираем класс при уходе курсора
    block.classList.add("visually-hidden"); // Возвращаем класс visually-hidden
    svg.classList.remove("location__pin--active"); // Убираем класс у svg
    path.classList.remove("location__pin--active"); // Убираем класс у path
  });
});

// Код для яндекс карты
if (typeof ymaps !== "undefined") {
  ymaps.ready(init);
} else {
  const script = document.createElement("script");
  script.src = "https://api-maps.yandex.ru/2.1/?apikey=28421986-ee3f-4925-8e70-56e640cf118e&lang=ru_RU";
  script.onload = () => ymaps.ready(init);
  document.head.appendChild(script);
}
function init() {
  const map = new ymaps.Map("map", {
    center: [52.253059, 104.330855],
    zoom: 12,
    controls: [],
  });

  const svgDefault = `
    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="55" viewBox="0 0 35 55" fill="none">
      <path d="M17.5 0C27.165 0 35 7.6463 35 17.0781C34.9997 26.5101 21.5753 45.788 17.5 54.8975C15.3425 49.8633 0.000323059 26.5101 0 17.0781C0 7.6463 7.83502 0 17.5 0ZM17.5 7.6709C12.0717 7.6709 7.6709 12.0717 7.6709 17.5C7.6709 22.9283 12.0717 27.3291 17.5 27.3291C22.9283 27.3291 27.3291 22.9283 27.3291 17.5C27.3291 12.0717 22.9283 7.6709 17.5 7.6709Z" fill="#7E7E7E"/>
    </svg>`;
  const svgHover = svgDefault.replace("#7E7E7E", "#B6B0B0");

  const hrefDefault =
    "data:image/svg+xml;utf8," + encodeURIComponent(svgDefault);
  const hrefHover = "data:image/svg+xml;utf8," + encodeURIComponent(svgHover);

  const locations = [
    {
      coords: [52.253059, 104.330855],
      name: "ЖК Нижняя Лисиха-3",
      desc: "ЖК Скандинавия </br> ЖК Нижняя Лисиха - 3</br> ЖК Сибиряков",
    },
    {
      coords: [52.268441, 104.32733],
      name: "ЖК Новый город-4 (Светлый)",
      desc: "ЖК Скандинавия </br> ЖК Нижняя Лисиха - 3</br> ЖК Сибиряков)",
    },
    {
      coords: [52.228403, 104.280102],
      name: "Радужный парк",
      desc: "ЖК Скандинавия </br> ЖК Нижняя Лисиха - 3</br> ЖК Сибиряков",
    },
  ];

  locations.forEach((loc) => {
    const placemark = new ymaps.Placemark(
      loc.coords,
      {
        balloonContent: loc.desc,
        hintContent: loc.name,
      },
      {
        iconLayout: "default#image",
        iconImageHref: hrefDefault,
        iconImageSize: [35, 55],
        iconImageOffset: [-17, -55],
      }
    );

    // Ховер‑эффект
    placemark.events
      .add("mouseenter", () =>
        placemark.options.set("iconImageHref", hrefHover)
      )
      .add("mouseleave", () =>
        placemark.options.set("iconImageHref", hrefDefault)
      );

    map.geoObjects.add(placemark);
  });
}
