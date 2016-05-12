<?php
 defined('LIBS_PATH') or die; interface JDatabaseQueryLimitable { public function processLimit($query, $limit, $offset = 0); public function setLimit($limit = 0, $offset = 0); }