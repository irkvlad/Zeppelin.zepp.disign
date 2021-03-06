<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ringclientsControllerRingclient extends ringclientsController
{
	
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}

	/**
	 * display the edit form
	 * @return void
	 *
	function edit()
	{
		JRequest::setVar( 'view', 'ringclient' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 *
	function save()
	{
		$model = $this->getModel('ringclient');

		if ($model->store($post)) {
			$msg = JText::_( 'ring client Saved!' );
		} else {
			$msg = JText::_( 'Error Saving ring client' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_zepp_ringclient';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('ringclient');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More ring client Could not be Deleted' );
		} else {
			$msg = JText::_( 'ring client(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_zepp_ringclient', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_zepp_ringclient', $msg );
	}
	
}