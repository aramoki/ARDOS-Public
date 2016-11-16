<?php
require_once '../../../kernel.php';
(new desktop($theme))->draw_desktop((new FIO())->list_dir_sorted(ABSPATH . 'desktop'));

