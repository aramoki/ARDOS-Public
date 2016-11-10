<!DOCTYPE html>
<!--
aramok.net openScript v1.2.1
for more information 
mohorame[at ] gmail [dot ] com
-->
<html>
    <head>
        <title>Aramok's Workspace</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="lib/jquery.js"></script>
        <script src="lib/jquery-ui.js"></script>
        <script src="lib/aramok.js"></script>
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.7.0/styles/xcode.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js"></script>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-31097804-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <body>
        <!---<div >
            Aramok's Personal workspace , all is freeware here you can download  , copy and use all of em.
        </div>--->
        <?php
        include 'kernel.php';
        (new desktop($theme))->draw_desktop((new FIO())->list_dir_sorted(ABSPATH . 'desktop'));
        ?>

    </body>

</html>


