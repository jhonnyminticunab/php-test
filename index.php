<?php

require_once 'controllers/template.controller.php';
require_once 'controllers/general.controller.php';
require_once 'controllers/users.controller.php';
require_once 'controllers/action.controller.php';
require_once 'controllers/sending.controller.php';

require_once 'models/general.models.php';

require_once 'models/routes.php';

require_once 'assets/plugins/vendor/autoload.php';

require_once 'assets/lib/nusoap.php';

$template = new ControllerTemplate();
$template -> ctrTemplate();