  <div class="container">
    <h1 class="page__title page__title--publication"><?=$card[0]['title']?></h1>
    <section class="post-details">
      <h2 class="visually-hidden">Публикация</h2>
      <div class="post-details__wrapper post-<?=$card[0]['class_name']?>">
        <div class="post-details__main-block post post--details">

          <?php
            $post_script_name = $card[0]['class_name'] . '.php';
            $post_content = include_template($post_script_name, [
              'text' => $card[0]['text_content'], 
              'author' => $card[0]['quote_auth'], 
              'url' => $card[0]['link_path'], 
              'title' => $card[0]['title'],
              'umg_url' => 'img/' . $card[0]['photo_path'],
              'youtube_url' => $card[0]['video_path']]);
            print($post_content);
          ?>

          <div class="post__indicators">
            <div class="post__buttons">
              <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                <svg class="post__indicator-icon" width="20" height="17">
                  <use xlink:href="#icon-heart"></use>
                </svg>
                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                  <use xlink:href="#icon-heart-active"></use>
                </svg>
                <span>250</span>
                <span class="visually-hidden">количество лайков</span>
              </a>
              <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                <svg class="post__indicator-icon" width="19" height="17">
                  <use xlink:href="#icon-comment"></use>
                </svg>
                <span>25</span>
                <span class="visually-hidden">количество комментариев</span>
              </a>
              <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                <svg class="post__indicator-icon" width="19" height="17">
                  <use xlink:href="#icon-repost"></use>
                </svg>
                <span>5</span>
                <span class="visually-hidden">количество репостов</span>
              </a>
            </div>
            <span class="post__view">500 просмотров</span>
          </div>
          <div class="comments">
            <form class="comments__form form" action="#" method="post">
              <div class="comments__my-avatar">
                <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
              </div>
              <div class="form__input-section form__input-section--error">
                <textarea class="comments__textarea form__textarea form__input" placeholder="Ваш комментарий"></textarea>
                <label class="visually-hidden">Ваш комментарий</label>
                <button class="form__error-button button" type="button">!</button>
                <div class="form__error-text">
                  <h3 class="form__error-title">Ошибка валидации</h3>
                  <p class="form__error-desc">Это поле обязательно к заполнению</p>
                </div>
              </div>
              <button class="comments__submit button button--green" type="submit">Отправить</button>
            </form>
            <div class="comments__list-wrapper">
              <ul class="comments__list">
                <?php foreach ($comments as $comment): ?>
                  <li class="comments__item user">
                    <div class="comments__avatar">
                      <a class="user__avatar-link" href="#">
                        <img class="comments__picture" src="img/<?=$comment['avatar_path'];?>" alt="Аватар пользователя">
                      </a>
                    </div>
                    <div class="comments__info">
                      <div class="comments__name-wrapper">
                        <a class="comments__user-name" href="#">
                          <span><?=$comment['username'];?></span>
                        </a>
                        <time class="comments__time" datetime="<?=$comment['creation_date'];?>"><?=format_date($comment['creation_date']);?></time>
                      </div>
                      <p class="comments__text">
                        <?=$comment['content'];?>
                      </p>
                    </div>
                  </li>
                <?php endforeach; ?>                
              </ul>
              <a class="comments__more-link" href="#">
                <span>Показать все комментарии</span>
                <sup class="comments__amount"><?=$comments_num[0]['comments_num'];?></sup>
              </a>
            </div>
          </div>
        </div>
        <div class="post-details__user user">
          <div class="post-details__user-info user__info">
            <div class="post-details__avatar user__avatar">
              <a class="post-details__avatar-link user__avatar-link" href="#">
                <img class="post-details__picture user__picture" src="img/<?=$card[0]['avatar_path'];?>" alt="Аватар пользователя">
              </a>
            </div>
            <div class="post-details__name-wrapper user__name-wrapper">
              <a class="post-details__name user__name" href="#">
                <span><?=$card[0]['username'];?></span>
              </a>
              <time class="post-details__time user__time" datetime="2014-03-20"><?=$years_on_site;?> на сайте</time>
            </div>
          </div>
          <div class="post-details__rating user__rating">
            <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
              <span class="post-details__rating-amount user__rating-amount"><?=$subscr_num[0]['subscr_num']?></span>
              <span class="post-details__rating-text user__rating-text">подписчиков</span>
            </p>
            <p class="post-details__rating-item user__rating-item user__rating-item--publications">
              <span class="post-details__rating-amount user__rating-amount"><?=$publ_num[0]['publ_num']?></span>
              <span class="post-details__rating-text user__rating-text">публикаций</span>
            </p>
          </div>
          <div class="post-details__user-buttons user__buttons">
            <button class="user__button user__button--subscription button button--main" type="button">Подписаться</button>
            <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
          </div>
        </div>
      </div>
    </section>
  </div>
