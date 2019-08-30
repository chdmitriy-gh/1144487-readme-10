<?php
$con = mysqli_connect('localhost', 'root', '', 'readme');
if (!$con) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    mysqli_set_charset($con, 'utf8');
    $sql = 'SELECT type_name, class_name FROM types';
    $res = mysqli_query($con, $sql);
    if (!$res) {
        $error = mysqli_error($con);
        print('Ошибка MySQL: ' . $error);
    } else {
        $types = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
}
?>
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="#">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all filters__button--active" href="#">
                            <span>Все</span>
                        </a>
                    </li>
                    
                    <?php foreach ($types as $curr_type):?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--<?=$curr_type['class_name'];?> button" href="#">
                            <span class="visually-hidden"><?=$curr_type['type_name'];?></span>
                            <?php 
                            switch (true) {
                                case ($curr_type['class_name'] === 'photo') :
                                    $type_width = '22';
                                    $type_height = '18';
                                    break;

                                case ($curr_type['class_name'] === 'video') :
                                    $type_width = '24';
                                    $type_height = '16';
                                    break;
                                
                                case ($curr_type['class_name'] === 'text') :
                                    $type_width = '20';
                                    $type_height = '21';
                                    break;

                                case ($curr_type['class_name'] === 'quote') :
                                    $type_width = '21';
                                    $type_height = '20';
                                    break;

                                case ($curr_type['class_name'] === 'link') :
                                    $type_width = '21';
                                    $type_height = '18';
                                    break;
                            }
                            ?>
                            <svg class="filters__icon" width="<?=$type_width;?>" height="<?=$type_height;?>">
                                <use xlink:href="#icon-filter-<?=$curr_type['class_name'];?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    
                </ul>
            </div>
        </div>

        <div class="popular__posts">        
            
        <?php foreach ($cards as $card): ?>    
            <article class="popular__post post post-<?=$card['class_name'];?>"> 
                <header class="post__header">
                    <h2><?=strip_tags($card['title']);?></h2>
                </header>
                <div class="post__main">
                    
                    <?php if ($card['class_name'] === 'quote'): ?>
                        <blockquote>
                            <p>
                                <?=strip_tags($card['text_content']);?>
                            </p>
                            <cite><?=strip_tags($card['quote_auth']);?></cite>
                        </blockquote>                     
                    <?php elseif($card['class_name'] === 'text'): ?> 
                        <p><?=format_text($card['text_content']);?></p>                       
                    <?php elseif($card['class_name'] === 'photo'): ?> 
                        <div class="post-photo__image-wrapper">
                            <img src="img/<?=$card['photo_path'];?>" alt="Фото от пользователя" width="360" height="240">
                        </div>                    
                    <?php elseif($card['class_name'] === 'link'): ?>
                        <div class="post-link__wrapper">
                            <a class="post-link__external" href="http://" title="Перейти по ссылке">
                            <div class="post-link__info-wrapper">
                                <div class="post-link__icon-wrapper">
                                    <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                                </div>
                                <div class="post-link__info">
                                    <h3><?=strip_tags($card['title']);?></h3>
                                </div>
                            </div>
                            <span><?=$card['link_path'];?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                
                </div>
                <footer class="post__footer">
                    <div class="post__author">
                        <a class="post__author-link" href="#" title="Автор">
                            <div class="post__avatar-wrapper">
                                <img class="post__author-avatar" src="img/<?=$card['avatar_path'];?>" alt="Аватар пользователя">
                            </div>
                            <div class="post__info">
                                <b class="post__author-name"><?=$card['username'];?></b>
                                <time class="post__time" datetime="<?=$card['creation_date'];?>" 
                                    title="<?=format_date_title($card['creation_date']);?>"> <?=format_date($card['creation_date']);?> 
                                </time> 
                            </div>
                        </a>
                    </div>
                    <div class="post__indicators">
                        <div class="post__buttons">
                            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                <svg class="post__indicator-icon" width="20" height="17">
                                    <use xlink:href="#icon-heart"></use>
                                </svg>
                                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                    <use xlink:href="#icon-heart-active"></use>
                                </svg>
                                <span>0</span>
                                <span class="visually-hidden">количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span>0</span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                        </div>
                    </div>
                </footer>
            </article> 
        <?php endforeach; ?> 

       </div>
    </div>