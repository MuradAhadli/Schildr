<?php
use yii\helpers\Html;
use app\models\Address;

$asset = \app\assets\AppAsset::register($this);

$isHome = yii::$app->session->get('isHome');

if ($isHome){
    $this->title = 'Main - '. Html::encode($this->title) ;
}
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="icon" href="<?= \yii\helpers\Url::base() ?>/favicon.png" type="image/x-icon">
        <link rel="canonical" href="https://schildr-nj.com/en"/>
        <meta property="og:site_name" content="Schildr Outdoor Solutions New Jersey"/>
        <meta property="og:title" content="Schildr Outdoor Solutions New Jersey| Retractable Awnings, Gazebos, Tents, Canopies, Blinds, Screens"/>
        <meta property="og:url" content="https://www.schildr-nj.com"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="Schildr Outdoor Solutions - High-end Retractable Motorized Pergola Awning &amp; Louver Systems, Gazebo, Canopy, Tent, Screen, Blind, Sliding Glass Doors at affordable prices."/>
        <meta name="description" content="Schildr Outdoor Solutions - High-end Retractable Motorized Pergola Awning &amp; Sunroom, Carport, Louver Systems, Gazebo, Canopy, Tent, Screen, Blind, Sliding Glass Doors at affordable prices." />
        <?php $this->head() ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-182375496-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-182375496-1');
        </script>
        <!-- Global site tag (gtag.js) - Google Ads: 478347887 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-478347887"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'AW-478347887');
        </script>
        <!-- Event snippet for getquote conversion page -->
        <script>
            if (document.location.href.match(/[^\/]+$/)[0]=='success'){
                gtag('event', 'conversion', {'send_to': 'AW-478347887/Mn7HCOCH2f8BEO-EjOQB'});
            }
        </script>
    </head>
    <body class="<?= $isHome ? 'home' : 'page' ?>">
    <?php $this->beginBody() ?>

    <?= $this->render('header') ?>

    <main id="<?= $isHome ? 'fullpage' : '' ?>">

        <?php
            if(!$isHome) {
                echo '<div class="content">';
            }

            echo $content;

            if(!$isHome) {
                echo '</div>';
            }

        ?>

        <?= $this->render('footer', [
                'isHome' => $isHome
        ]) ?>

    </main>

    <script>
        var app_lang = '<?= yii::$app->language ?>';

        var branches = [];

        <?php
                $i = 0;
        $address = Address::getAllAddress();
        foreach ($address as $key => $val) : ?>
            branches.push([<?=$i?>, '<?=$val['title']?>', <?=$val['coor_x']?>, <?=$val['coor_y']?>, 'object_2', 'map.svg', <?=$val['id']?>])
        <?php $i++; endforeach; ?>

        var web_url = '<?= yii::getAlias('@web') ?>';

        var domain = '<?= \yii\helpers\Url::to(['/']) ?>';
    </script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(74505439, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/74505439" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>