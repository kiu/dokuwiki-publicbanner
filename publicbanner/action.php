<?php

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_publicbanner extends DokuWiki_Action_Plugin {

    function register(&$controller) {
        $controller->register_hook('TPL_ACT_RENDER', 'BEFORE', $this, handle_before, array());
    }

    function handle_before(&$event, $param) {
	if(!$this->valid_action()) {
	    return true;
	}

	global $ID;
	$perm = auth_aclcheck($ID, null, null);

	if ($perm > 0) {
	    $strings = array();
	    $strings[] = 'Reminder: <i>This page is visible to the public</i>.';
	    $strings[] = '<hr>';
	    ptln(implode($strings));
	}

	return true;
    }

    function valid_action() {
        # Only show Classifications Banner on displays
        # of pages that are about that page (i.e. not admin
        # or recent changes)
        global $ACT;
        if($ACT == 'show') { return true; }
        if($ACT == 'edit') { return true; }
        if($ACT == 'revisions') { return true; }
        return false;
    }
}
