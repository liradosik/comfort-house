<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_comforthouse
 *
 * @copyright   Copyright (C) 2005 - 2023 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Подключаем CSS и JS через Joomla API
$doc = JFactory::getDocument();
$doc->addScript('https://api-maps.yandex.ru/2.1/?apikey=28421986-ee3f-4925-8e70-56e640cf118e&lang=ru_RU', ['defer' => 'defer']);
$doc->addStyleSheet('templates/' . $this->template . '/styles/style.css');
$doc->addScript('templates/' . $this->template . '/js/index.js', array('defer' => 'defer'));
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <jdoc:include type="head" />
    <title>Комфортный дом</title>
  </head>
  <body>
    <header class="header">
      <div class="header__inner">
        <div class="header__logo">
          <img
            src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/images/logo.png"
            alt="Логотип комфортный дом"
            class="header__logo-image"
            width="171"
            height="139"
            loading="lazy"
          />
        </div>
        <nav class="header__menu">
          <ul class="header__menu-list">
            <li class="header__menu-item header__menu-item--active">
              <a href="#hero" class="header__menu-link">О нас</a>
            </li>
            <li class="header__menu-item">
              <a href="#info" class="header__menu-link">Новосёлам</a>
            </li>
            <li class="header__menu-item">
              <a href="#location" class="header__menu-link"
                >Дома в управлении</a
              >
            </li>
            <li class="header__menu-item">
              <a href="#end" class="header__menu-link">Комфорт в деталях</a>
            </li>
            <li class="header__menu-item">
              <a href="#footer" class="header__menu-link">Контакты</a>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <div class="header__scroll visually-hidden">
      <nav class="header__menu">
        <ul class="header__menu-list">
          <li class="header__menu-item">
            <a href="#hero" class="header__menu-link">О нас</a>
          </li>
          <li class="header__menu-item header__menu-item--active">
            <a href="#info" class="header__menu-link">Новосёлам</a>
          </li>
          <li class="header__menu-item">
            <a href="#location" class="header__menu-link">Дома в управлении</a>
          </li>
          <li class="header__menu-item">
            <a href="#end" class="header__menu-link">Комфорт в деталях</a>
          </li>
          <li class="header__menu-item">
            <a href="#footer" class="header__menu-link">Контакты</a>
          </li>
        </ul>
      </nav>
    </div>

    <section class="section">
      <div class="hero" id="hero">
        <div class="hero__title">
          <span class="hero__title-above"
            >Наша <span class="hero__title-bold">цель –</span></span
          >
          <div class="hero__title-text">
            <span class="hero__title-text hero__title-text--first"
              >комфортное</span
            >
            <span class="hero__title-text hero__title-text--second"
              >безопасное</span
            >
            <span class="hero__title-text hero__title-text--third"
              >технологичное</span
            >
          </div>
          <span class="hero__title-below"
            >содержание <span class="hero__title-bold">Вашего дома</span></span
          >
        </div>
        <img
          src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/images/hero_house.png"
          alt=""
          class="hero__image"
          height="783"
          width="1600"
          loading="lazy"
        />
      </div>
      <section class="info" id="info">
        <h2 class="info__title">Добро пожаловать домой!</h2>
        <div class="info__description">
          <p>
            Комфортный дом поздравляет Вас с приобретением квартиры,<br />
            одной из <b>главных покупок</b> в жизни каждого!
          </p>
          <p>
            Приглашаем Вас познакомиться с управляющей компанией<br />
            и услугами, которые мы предоставляем.
          </p>
          <p>
            Здесь Вы найдете <b>всю необходимую информацию</b><br />
            для комфортной жизни в Вашем новом доме
          </p>
        </div>
      </section>
    </section>

    <section class="location" id="location">
      <div id="map"></div>
    </section>

    <section class="end" id="end">
      <div class="container">
        <div class="end__description">
          Здесь мы будем делиться новостями, полезными советами,<br />
          идеями и интересными лайфхаками. <br />
          <br />
          Присоединяйтесь к нам, и давайте вместе сделаем Ваш дом местом, где
          приятно находиться! <br />
        </div>
        <ul class="end__list">
          <li class="end__item">
            <a href="#" class="end__link">Подать показания</a>
          </li>
          <li class="end__item">
            <a href="#" class="end__link">Перейти на электронную квитанцию</a>
          </li>
          <li class="end__item">
            <a href="#" class="end__link"
              >Получить и оплатить электронную квитанцию</a
            >
          </li>
          <li class="end__item">
            <a href="#" class="end__link">Подача заявки онлайн</a>
          </li>
        </ul>
      </div>
    </section>

    <footer class="footer" id="footer">
      <h2 class="footer__title container">Контактная информация</h2>
    </footer>
    
    <jdoc:include type="modules" name="debug" />
  </body>
</html>