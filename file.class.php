<?php

/*

Example Usage:

---------------
Writing To File
---------------

<?php
require 'file.class.php';

$file = new File('/path/to/new/filename.txt', 'wb');
$lines = array('First Line', 'Second Line', 'Third Line');
foreach($lines as $line) {
	$file->write($line . "\r\n");
}
$file->close();

-----------------
Reading From File
-----------------

<?php
require 'file.class.php';

$file = new File('/path/to/existing/filename.txt', 'rb');
foreach($file as $chunk) {
	print $chunk . "\r\n";
}
$file->close();

-------------
Renaming File
-------------
$file = new file('/path/to/existing/filename.txt', 'rb');
$file->rename('/path/to/new/filename.txt');
$file->close();

*/

class FileException extends Exception {}

class File extends FileHelper implements Iterator {
	private $fp;
	private $file_or_directory;
	private $iterator_line_count;

	/**
	 * 
	 * @param type $file_or_directory
	 * @param type $mode
	 * @param type $use_include_path
	 * @param type $context
	 * @throws FileException
	 */
	public function __construct($file_or_directory, $mode = 'wb', $use_include_path = False, $context = False) {
		if($context === False) {
			$this->fp = fopen($file_or_directory, $mode, $use_include_path);
		} else {
			$this->fp = fopen($file_or_directory, $mode, $use_include_path, $context);
		}

		// Make sure we're successfully been returned a file resource.
		if($this->fp === False) {
			throw new FileException('Unable to create `File` object resource, please check your parameters');
		}

		$this->file_or_directory = $file_or_directory;
	}

	public function __call($method, $arguments) {
		if(substr($method, 0, 1) !== '_') {
			$method = '_' . $method;
		}
		print 'Method to Call: self::' . $method . '()<br />';
		if(method_exists('File', $method)) {
			// TODO: If no arguments are passed, is empty array, Null, or False
			// passed? Might not need this logic.
			if(!is_array($arguments)) {
				$arguments = array();
			}

			$arguments = array_merge(
				array(
					$this->file_or_directory
				),
				$arguments
			);

			return call_user_func_array(
				'File::' . $method,
				$arguments
			);
		}
		throw new FileException('Method `' . $method . '` does not exist');
	}

	/**
	 * Close the file pointer.
	 * 
	 * @return boolean
	 */
	public function close() { // http://us3.php.net/manual/en/function.fclose.php
		return fclose($this->fp);
	}

	/**
	 * Read and return a single line from the file.
	 * 
	 * @param integer $length
	 * @return string
	 */
	public function readLine($length = False) { // http://us3.php.net/manual/en/function.fgets.php
		if($length === False) {
			return fgets($this->fp);
		} else {
			return fgets($this->fp, $length);
		}
	}

	/**
	 * Read and return a single character from the file.
	 * 
	 * @return string
	 */
	public function readChar() { // http://us3.php.net/manual/en/function.fgets.php
		return fgets($this->fp);
	}

	/**
	 * 
	 * @param string $delimiter
	 * @param integer $length
	 * @param string $enclosure
	 * @param string $escape
	 * @return string
	 */
	public function readAsDelimited($delimiter, $length = 0, $enclosure = '"', $escape = '\\') {
		return fgetcsv($this->fp, $length, $delimiter, $enclosure, $escape);
	}

	/**
	 * 
	 * @param integer $length
	 * @param string $enclosure
	 * @param string $escape
	 * @return string
	 */
	public function readAsCsv($length = 0, $enclosure = '"', $escape = '\\') {
		return $this->readAsDelimited(',', $length, $enclosure, $escape);
	}

	/**
	 * 
	 * @param integer $length
	 * @param string $enclosure
	 * @param string $escape
	 * @return string
	 */
	public function readAsTsv($length = 0, $enclosure = '"', $escape = '\\') {
		return $this->readAsDelimited("\t", $length, $enclosure, $escape);
	}

	/**
	 * 
	 * @param integer $length
	 * @return string
	 */
	public function read($length = 8192) { // http://us3.php.net/manual/en/function.fread.php
		return fread($this->fp, $length);
	}

	/**
	 * 
	 * @return string
	 */
	public function readAll() {
		return file_get_contents($this->fp);
	}

	/**
	 * 
	 * @param string $data
	 * @param integer $length
	 * @return boolean
	 */
	public function write($data, $length = False) { // http://us3.php.net/manual/en/function.fwrite.php
		if($length === False) {
			return fwrite($this->fp, $data);
		} else {
			return fwrite($this->fp, $data);
		}
	}

	/**
	 * 
	 * @return integer
	 */
	public function getOffset() {
		return ftell($this->fp);
	}

	/**
	 * 
	 * @param integer $offset
	 * @return boolean
	 */
	public function setOffset($offset) {
		return fseek($this->fp, $offset);
	}

	/**
	 * 
	 * @return boolean
	 */
	public function rewindOffset() {
		return rewind($this->fp);
	}

	/**
	 * 
	 * @param boolean $would_block
	 * @return boolean
	 */
	public function setReadLock($would_block = False) { // http://us3.php.net/manual/en/function.flock.php
		if($would_block === False) {
			return flock($this->fp, LOCK_SH);
		} else {
			return flock($this->fp, LOCK_SH, $would_block);
		}
	}

	/**
	 * 
	 * @param boolean $would_block
	 * @return boolean
	 */
	public function setWriteLock($would_block = False) { // http://us3.php.net/manual/en/function.flock.php
		if($would_block === False) {
			return flock($this->fp, LOCK_EX);
		} else {
			return flock($this->fp, LOCK_EX, $would_block);
		}
	}

	/**
	 * 
	 * @param boolean $would_block
	 * @return boolean
	 */
	public function removeLock($would_block = False) { // http://us3.php.net/manual/en/function.flock.php
		if($would_block === False) {
			return flock($this->fp, LOCK_UN);
		} else {
			return flock($this->fp, LOCK_UN, $would_block);
		}
	}

	/**
	 * 
	 * @return string
	 */
	public function getFileOrDirectoryName() {
		return $this->file_or_directory;
	}

	/**
	 * 
	 * @param string $file_or_directory
	 * @return boolean
	 */
	public function rename($file_or_directory) {
		$old_file_or_directory = $this->file_or_directory;
		$this->file_or_directory = $file_or_directory;
		return rename($old_file_or_directory, $file_or_directory);
	}

	/**
	 * 
	 * @param string $file_or_directory
	 * @return boolean
	 */
	public function copy($file_or_directory) {
		return copy($this->file_or_directory, $file_or_directory);
	}

	/**
	 * 
	 * @return boolean
	 */
	public function delete() {
		return $this->unlink($this->file_or_directory);
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isEof() {
		return feof($this->fp);
	}

	/**
	 * Iterator implementation specific methods
	 */

	public function rewind() {
		$this->rewindOffset();
		$this->iterator_line_count = 0;
	}

	public function current() {
		return $this->readLine();
	}

	public function key() {
		$this->iterator_line_count;
	}

	public function next() {
		$this->iterator_line_count++;
		return $this->isEof() === True ? False : True;
	}

	public function valid() {
		return $this->isEof() === True ? False : True;
	}
}

class FileHelper {
	public static function __callStatic($function, $arguments) {
		if(substr($function, 0, 1) !== '_') {
			$function = '_' . $function;
		}
		if(method_exists('FileHelper', $function)) {
			return call_user_func_array(
				'FileHelper::' . $function,
				$arguments
			);
		}
		throw new FileException('Method `' . $method . '` does not exist');
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return octal
	 */
	public static function _getUmask($file_or_directory = Null) { // http://us3.php.net/manual/en/function.umask.php
		return umask();
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return octal
	 */
	public static function _setUmask($file_or_directory = Null) { // http://us3.php.net/manual/en/function.umask.php
		return umask($mask);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return octal
	 */
	public static function _getPermissions($file_or_directory) { // http://us3.php.net/manual/en/function.fileperms.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return fileperms($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @param octal $mode
	 * @return boolean
	 */
	public static function _setMode($file_or_directory, $mode) { // http://us3.php.net/manual/en/function.chmod.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return chmod($file_or_directory, $mode);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return integer
	 */
	public static function _getGroupId($file_or_directory) { // http://us3.php.net/manual/en/function.filegroup.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return filegroup($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return string
	 */
	public static function _getGroupName($file_or_directory) { // http://us3.php.net/manual/en/function.posix-getgrgid.php
		$group_id = self::_getGroupId($file_or_directory);
		return posix_getgrgid($group_id);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @param integer $group_id
	 * @return boolean
	 */
	public static function _setGroupById($file_or_directory, $group_id) { // http://us3.php.net/manual/en/function.chgrp.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return chgrp($file_or_directory, (integer)$group_id);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @param string $group_name
	 * @return boolean
	 */
	public static function _setGroupByName($file_or_directory, $group_name) { // http://us3.php.net/manual/en/function.chgrp.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return chgrp($file_or_directory, (string)$group_name);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return integer
	 */
	public static function _getOwnerId($file_or_directory) { // http://us3.php.net/manual/en/function.fileowner.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return fileowner($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return string
	 */
	public static function _getOwnerName($file_or_directory = False) { // http://us3.php.net/manual/en/function.fileowner.php
		if($file_or_directory === False) {
			$file_or_directory = $this->file_or_directory;
		}
		$user_id = self::_getOwnerId($file_or_directory);
		return posix_getpwuid($user_id);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @param integer $user_id
	 * @return boolean
	 */
	public static function _setOwnerById($file_or_directory, $user_id) { // http://us3.php.net/manual/en/function.chown.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return chown($file_or_directory, (integer)$user_id);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @param string $user_name
	 * @return boolean
	 */
	public static function _setOwnerByName($file_or_directory, $user_name) { // http://us3.php.net/manual/en/function.chown.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return chown($file_or_directory, (string)$user_name);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return integer
	 */
	public static function _getInode($file_or_directory) { // http://us3.php.net/manual/en/function.fileinode.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return fileinode($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return boolean
	 */
	public static function _exists($file_or_directory) { // http://us3.php.net/manual/en/function.file-exists.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return file_exists($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return boolean
	 */
	public static function _isReadable($file_or_directory) { // http://us3.php.net/manual/en/function.is-readable.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return is_readable($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return boolean
	 */
	public static function _isWritable($file_or_directory) { // http://us3.php.net/manual/en/function.is-writable.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return is_writable($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return boolean
	 */
	public static function _isExecutable($file_or_directory) { // http://us3.php.net/manual/en/function.is-executable.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return is_executable($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return boolean
	 */
	public static function _isDirectory($file_or_directory) { // http://us3.php.net/manual/en/function.is-dir.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return is_dir($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return boolean
	 */
	public static function _isFile($file_or_directory) { // http://us3.php.net/manual/en/function.is-file.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return is_file($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return boolean
	 */
	public static function _isLink($file_or_directory) { // http://us3.php.net/manual/en/function.is-link.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return is_link($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return boolean
	 */
	public static function _isUploadedFile($file_or_directory) { // http://us3.php.net/manual/en/function.is-uploaded-file.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return is_uploaded_file($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return array
	 */
	public static function _getInfo($file_or_directory) { // http://us3.php.net/manual/en/function.stat.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return stat($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @param string $suffix
	 * @return string
	 */
	public static function _getBaseName($file_or_directory, $suffix = False) { // http://us3.php.net/manual/en/function.basename.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		if($suffix === False) {
			return basename($file_or_directory);
		}
		return basename($file_or_directory, $suffix);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return integer
	 */
	public static function _getSize($file_or_directory) {
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return filesize($file_or_directory, $suffix);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return string
	 */
	public static function _getParentDirectory($file_or_directory) { // http://us3.php.net/manual/en/function.dirname.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return dirname($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return integer
	 */
	public static function _getLastAccessed($file_or_directory) { // http://us3.php.net/manual/en/function.fileatime.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return fileatime($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return integer
	 */
	public static function _getLastModified($file_or_directory) { // http://us3.php.net/manual/en/function.filectime.php
		$file_or_directory = self::_getFileOrDirectoryName($file_or_directory);
		return filectime($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return float
	 */
	public static function _getDiscFreeSpace($file_or_directory = '/') { // http://us3.php.net/manual/en/function.disk_free_space.php
		return disk_free_space($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return float
	 */
	public static function _getDiscTotalSpace($file_or_directory = '/') { // http://us3.php.net/manual/en/function.disk_total_space.php
		return disk_total_space($file_or_directory = '/');
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return float
	 */
	public static function _getDiscUsedSpace($file_or_directory = '/') {
		return self::_getDiscTotalSpace($file_or_directory) - self::_getDiscFreeSpace($file_or_directory);
	}

	/**
	 * 
	 * @param File|string $file_or_directory
	 * @return string:
	 */
	private static function _getFileOrDirectoryName($file_or_directory) {
		if($file_or_directory instanceof File) { // Support for passing `File` object.
			return $file_or_directory->getFileOrDirectoryName();
		}
		return $file_or_directory;
	}
}
