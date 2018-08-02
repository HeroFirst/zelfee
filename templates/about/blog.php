<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */

include __DIR__.'/../header-simple.php'; ?>

    <div class="page-content">
        <div class="container">

            <div class="row margin-top-40">
                <div class="col-xs-12">
                    <div class="flex flex-vertical-center flex-left-right">
                        <div class="box-title-page">

                        </div>

                        <div class="zf-tabs-big">
                            <ul>
                                <li><a href="/<?=$AppUser->getInfoItem('city_alias')?>/about/history"><span class="zf-icon-about-history"></span>Подробнее о ЗФ</a></li>
                                <li class="active"><a href="/<?=$AppUser->getInfoItem('city_alias')?>/about/blog"><span class="zf-icon-about-blog-white"></span> Стратегия 2020</a></li>
                                <li class="hide"><a href="/<?=$AppUser->getInfoItem('city_alias')?>/about/smi"><span class="zf-icon-about-smi"></span> СМИ о нас</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row margin-top-50">
                <div class="col-xs-3">
                    <div class="box-title-page">
                        <h1>Стратегия 2020</h1>
                    </div>
                    <p class="about-title-description margin-top-20">—  это история о том как простые студенты из Казани решили вовлечь в занятия спортом 1 млн участников.</p>
                </div>
                <div class="col-xs-9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/mTHB8_hCA0o" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>

            <div class="row margin-top-50">
                <div class="col-xs-12">
                    <div class="box-title-page">
                        <h1>Что нас ждет на пути к поставленной цели?</h1>
                    </div>
                </div>
            </div>

            <div class="about-goals-container">
                <div class="row margin-top-50">

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    Начиная наш проект, мы понимали, что нам нужна поддержка со стороны государства и уже через 3-4 проведенных мероприятий мы выходим на Министерство по делам молодежи и спорту РТ, которое является нашим официальным партнером с весны 2015 года. Сам проект высоко оценивается среди руководства министерства и широко представляется на разных уровнях.
                                </p>
                                <a target="_blank" href="//mdms.tatarstan.ru/rus/index.htm/news/439260.htm">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_1_active.png)"></div>
                            <div class="goal-title">Получить поддержку<br /> государства</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    В 2015 году занятия Зеленого Фитнеса проходили только в одном городе – Казани в Центральном парке культуры и отдыха им. Горького.  В 2016 году заручившись генеральной поддержкой компании Татнефть мы запускаем проект в Альметьевске 28 мая 2016 года, параллельно мероприятия проходили в Казани на 2 площадках: Парк Горького и Парк Победы. На этом мы не остановимся и будем расширяться дальше!
                                </p>
                                <a target="_blank" href="//mdms.tatarstan.ru/rus/index.htm/news/654253.htm">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_2_active.png)"></div>
                            <div class="goal-title">Запустить ЗФ в 2016 году<br /> еще в 2-х городах</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    Изначально предполагалось проводить Зеленый Фитнес только на улице, отталкиваясь от концепции полезных занятий на свежем воздухе в парках и скверах городов. Однако спустя некоторое время, собрав множество отзывов и пожеланий о запуске занятий во все сезоны года.  Наш первый город с таким форматом – Альметьевск. Более 160 мероприятий,  обновленный формат мероприятий (сочетание занятий на улице и залах) и море новинок – все это и многое другое ожидает жителей Альметьевска уже с 6 ноября 2016 г.
                                </p>
                                <a target="_blank" href="/news/6">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_3_active.png)"></div>
                            <div class="goal-title">Разработать и запустить<br /> круглогодичный формат ЗФ</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    31 июля был проведен «Зеленый Фитнес» при официальной поддержке партнера проекта компании «Мегафон», которая пригласила на нашу зеленую лужайку Олимпийского чемпиона, именитого волейболиста Александра Бутько. В рамках данного занятия был организован мастер-класс по правильной разминке от известного спортсмена, автограф-сессия и спортивный интерактив «Забей с паса Бутько»
                                </p>
                                <a target="_blank" href="//vk.com/zf_kzn?w=wall-91272415_3328">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_4_active.png)"></div>
                            <div class="goal-title">Пригласить олимпийского<br /> чемпиона на ЗФ</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    28 августа на закрытии летнего сезона ЗФ-2016 Официальным гостем мероприятия становится Первый заместитель председателя, член исполкома Олимпийского комитета России Бариев Марат Мансурович, который конечно же положительно относится к теме популяризации здорового образа жизни и развитию спорта в нашей стране. Марат Мансурович пожелал всем участникам и дальше активно заниматься спортом, не забывать про свое здоровье, а также вручил активным участникам проекта Зеленый Фитнес почетные грамоты.
                                </p>
                                <a target="_blank" href="//vk.com/wall-91272415_3808">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_5_active.png)"></div>
                            <div class="goal-title">Пригласить депутата<br /> Госдумы на ЗФ</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    Такого отличного количественного показателя мы добились на открытии проекта «Зеленый Фитнес» в г. Альметьевске 28 мая на площади Нефтяков.  И с каждым новым мероприятием в спорт вовлекается все больше жителей и гостей нефтяной столицы Татарстана
                                </p>
                                <a target="_blank" href="//zt16.ru/2016/05/sezon-zelenogo-fitnesa-v-almetevske-otkryt/">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_6_active.png)"></div>
                            <div class="goal-title">Собрать на одной площадке<br /> 3000 участников</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    Высокопоставленные гости на наших мероприятиях – очень важный момент! Мы решили выполнить эту цель и пригласили мэра г. Альметьевск Хайруллина Айрата Ринатовича, такая возможность нам представилась не только на официальном открытии проекта 28 мая 2016 г., но и на нескольких штатных мероприятиях, где он был радушно встречен организаторами и участниками проекта.  Сэлфи с мэром города, ведь круто?:)
                                </p>
                                <a target="_blank" href="//www.instagram.com/p/BF8079PIMmf/?taken-by=khayrullinayrat&hl=ru">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_7_active.png)"></div>
                            <div class="goal-title">Пригласить на ЗФ<br /> мэра города</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    Данный проект интересен не только рядовым жителям города, различным компаниям, но и профессиональным спортивным командам. 17 июля 2016 года на Зеленый Фитнес в Альметьевске были приглашены хоккеисты ХК «Нефтяник» - спортивная гордость г. Альметьевск. Участника на ура приняли профессиональных спортсменов, ведь они могли с ними вместе заниматься фитнесом на одной площадке, участвовать в тематических конкурсах и получить приятные подарки от хоккеистов.  Окажемся в Испании если, позовем ФК Барселону, берем пока на заметку
                                </p>
                                <a target="_blank" href="//www.ahc-neftyanik.ru/novosti-neftyanika/neftyanik-potrenirovalsya-s-almetevtsami-na-ploshchadkakh-goroda/?sphrase_id=417">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_8_active.png)"></div>
                            <div class="goal-title">Пригласить на ЗФ профессиональную<br /> хоккейную команду</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    Наш столетний юбилей состоялся в сезоне 2016 года. В Казани и Альметьевске было проведено более 100 мероприятий на 7 различных площадках. Мероприятия проводились еженедельно параллельно на всех площадках в одно и тоже время.
                                </p>
                                <a target="_blank" href="//vk.com/zf_kzn?w=wall-91272415_3863">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_9_active.png)"></div>
                            <div class="goal-title">Провести 100 мероприятий ЗФ<br /> с мастерклассами</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    Зеленый Фитнес сочетает себе и спорт, и творчество.  Мы всегда наполняем нашу программу интересными творческими номерами. Особенно наши участники любят танцевальные направления. 28 августа с показательным мастер-классом по направлению House выступил опытнейший тренер, участник шоу «Танцы на ТНТ», победитель различных танцевальных соревнований, руководитель танцевальной кузницы «HousePro»
                                </p>
                                <a target="_blank" href="//vk.com/fayzer36?w=wall9024536_4493">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_10_active.png)"></div>
                            <div class="goal-title">Мастер-класс с участником<br /> шоу «Танцы» на ТНТ</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item goal-item-finished">
                            <div class="goal-description">
                                <p>
                                    Лезгинка в центральном парке города? Да запросто! Зеленый Фитнес на закрытии летнего сезона 28 августа устроил настоящий танцевальный праздник: всех участников ожидал очень энергичный мастер-класс по лезгинке от тренера Сиража Джавадбекова. Сираж окончил хореографическую школу при дворце детского юношеского творчества "Гюнеш" г.Дербент, работал в муниципальном ансамбле танца "Дербент" после ставший государственный ансамбль танца "Каспий", участник всекавказского фестиваля в г.Ялова Турция 2007г., лауреат первой степени международного фестиваля танца 2009 г. Гелати Румыния, в 2010 году участник международного фестиваля народных культур г. Анкара Турция, участник шоу "ТАНЦЫ" на ТНТ 1 сезон, 100 лучших шоу "ТАНЦУЙ" на первом канале, сейчас работает в школе танца "ТЕАТР ТАНЦА "СЭМБЕЛЬ" класс Лезгинка г.Казань
                                </p>
                                <a target="_blank" href="//vk.com/siraj04405?w=wall58223179_3501">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_11_active.png)"></div>
                            <div class="goal-title">Провести лезгинку<br /> на Зеленом Фитнесе</div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="goal-item">
                            <div class="goal-description">
                                <p>
                                </p>
                                <a href="#">подробнее >></a>
                            </div>
                            <div class="goal-icon-status"></div>
                            <div class="goal-cover" style="background-image: url(/assets/images/goals/goal_12.png)"></div>
                            <div class="goal-title">Провести Зеленый Фитнес<br /> в космосе</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

<?php include __DIR__.'/../footer.php' ?>