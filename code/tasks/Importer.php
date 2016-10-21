<?php
namespace Quaff\SiteTree\Tasks;
use Modular\tokens;
use Quaff\Api;
use Quaff\Interfaces\Transport;
use Quaff\Tasks\SyncTask;
use Quaff\Transports\Protocol\http;

/**
 * Importer
 *
 * @package Quaff\Tasks\SiteTree
 */
class Importer extends SyncTask {
	use tokens;
	use http;

	public $description = 'Import CSV to Site Tree';

	const ApiServiceAlias = 'sitetree-importer';
	const EndpointAlias = 'import:sitetree';

	private static $endpoints = [
		self::EndpointAlias
	];

	public function getDescription() {
		return "Import CSV from '" . $this->getFilePathName() . "' to Site Tree Pages";
	}

	public function getFilePathName() {
		/** @var Api $api */
		foreach (Api::locate(static::ApiServiceAlias) as $api) {
			if ($endpoint = $api->endpoint(static::EndpointAlias)) {
				return $this->sanitisePath($endpoint->getURI(Transport::ActionRead));
			}
		}
	}
}