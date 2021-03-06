<?php

namespace SlackHookFramework;

/**
 * Class to show usage of the slack-hook-framework.
 *
 * @author Luis Augusto PeÃ±a Pereira <lpenap at gmail dot com>
 *        
 */
class CmdHello extends AbstractCommand {
	
	/**
	 * Factory method to be implemented from \SlackHookFramework\AbstractCommand .
	 * Must return an instance of \SlackHookFramework\SlackResult .
	 *
	 * Basically, the method returns an instance of SlackResult.
	 * Inside a single instance of SlackResult, several
	 * SlackResultAttachment instances can be stored.
	 * Inside a SlackResultAttachment instance, several
	 * SlackResultAttachmentField instances can be stored.
	 * The result is then formating according to the Slack
	 * formating guide.
	 *
	 * So you must process your command here, and then
	 * prepare your SlackResult instance.
	 *
	 * @see \SlackHookFramework\AbstractCommand::executeImpl()
	 * @return \SlackHookFramework\SlackResult
	 */
	protected function executeImpl() {
		/**
		 * Get a reference to the log.
		 */
		$log = $this->log;
		
		/**
		 * Create a new instance to store results.
		 */
		$result = new SlackResult ();
		
		/**
		 * Output some debug info to log file.
		 */
		$log->debug ( "CmdHello: Parameters received: " . implode ( ",", $this->cmd ) );
		
		/**
		 * Preparing the result text and validating parameters.
		 */
		$resultText = "[requested by " . $this->post ["user_name"] . "]";
		if (empty ( $this->cmd )) {
			$resultText .= " You must specify at least one parameter!";
		} else {
			$resultText .= " CmdHello Result: ";
		}
		
		/**
		 * Preparing attachments.
		 */
		$attachments = array ();
		
		/**
		 * Cycling through parameters, just for fun.
		 */
		foreach ( $this->cmd as $param ) {
			$log->debug ( "CmdHello: processing parameter $param" );
			
			/**
			 * Preparing one result attachment for processing this parameter.
			 */
			$attachment = new SlackResultAttachment ();
			$attachment->setTitle ( "Processing $param" );
			$attachment->setText ( "Hello $param !!" );
			$attachment->setFallback ( "fallback text." );
			$attachment->setPretext ( "pretext here." );
			
			/**
			 * Adding some fields to the attachment.
			 */
			$fields = array ();
			$fields [] = SlackResultAttachmentField::withAttributes ( "Field 1", "Value" );
			$fields [] = SlackResultAttachmentField::withAttributes ( "Field 2", "Value" );
			$fields [] = SlackResultAttachmentField::withAttributes ( "This is a long field", "this is a long Value", FALSE );
			$attachment->setFieldsArray ( $fields );
			
			/**
			 * Adding the attachment to the attachments array.
			 */
			$attachments [] = $attachment;
		}
		
		$result->setText ( $resultText );
		$result->setAttachmentsArray ( $attachments );
		return $result;
	}
}
