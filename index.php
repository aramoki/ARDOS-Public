<!DOCTYPE html>
<!--
aramok.net openScript v1.2.2710ext
for more information 
mohorame[at ] gmail [dot ] com
-->
<html>
    <head>
        <title>Aramok's Workspace</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="lib/aramok.js"></script>
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.7.0/styles/xcode.min.css">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.7.0/highlight.min.js"></script>
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
        <?php
        include 'kernel.php';
        $filereader = new FIO();
        $icons = $filereader->list_dir_sorted(ABSPATH.'desktop');


        /*
         * 
         *  Aramok.net
         *  so you find it ^_^
         *  you can copy script , and use it freeely 
         *  its simple and usefull , dont forget js and css files
         * 
         */

        $desktop = new desktop();
        $desktop->draw_desktop($icons);
        ?>
    </body>
</html>


