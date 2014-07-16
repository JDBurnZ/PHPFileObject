PHPFileObject
=============

An implementation of PHP's file management utilities built into a more friendly interface.

Function Reference: File
-

These methods must be called on an instantiated `File` object.

The `File` object implements all methods from the `FileHelper` class, callable in an instantiated manner. When calling methods inherited from the `FileHelper` class, the first argument (`$file_or_directory`) is assumed and should not be passed; all other arguments should be passed as normal.

<table>
<thead><tr>
	<th>Function</th>
	<th>Arguments</th>
	<th>Returns</th>
	<th>Description</th>
</tr></thead><tbody>
<tr>
	<td>__construct</td>
	<td>(string)$file_or_directory<br />(string)$mode='wb'<br />(boolean)$use_include_path=False<br />(context)$context=False</td>
	<td>boolean</td>
	<td></td>
</tr>
<tr>
	<td>close</td>
	<td></td>
	<td>boolean</td>
	<td>Close the file pointer.</td>
</tr>
<tr>
	<td>copy</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Copy the file to another location.</td>
</tr>
<tr>
	<td>delete</td>
	<td></td>
	<td>boolean</td>
	<td>Delete the file.</td>
</tr>
<tr>
	<td>getFileOrDirectoryName</td>
	<td></td>
	<td>string</td>
	<td>Returns the file name associated with file opened.</td>
</tr>
<tr>
	<td>getOffset</td>
	<td></td>
	<td>integer</td>
	<td>Gets the current offset of the file pointer.</td>
</tr>
<tr>
	<td>isEof</td>
	<td></td>
	<td>boolean</td>
	<td>Whether or not the file pointer has reached the end of the file.</td>
</tr>
<tr>
	<td>read</td>
	<td>(integer)$length=8192</td>
	<td>string</td>
	<td>Read and return file in $length (in bytes,) sized chunks.</td>
</tr>
<tr>
	<td>readAll</td>
	<td></td>
	<td>string</td>
	<td>Read and return the entire file's contents all at once.</td>
</tr>
<tr>
	<td>readAsCsv</td>
	<td>(integer)$length=0<br />(string)$enclosure='"'<br />(string)$escape='\\'</td>
	<td>array</td>
	<td>Read and return file contents formatted as CSV.</td>
</tr>
<tr>
	<td>readAsDelimited</td>
	<td>(string)$delimiter<br />(integer)$length=0<br />(string)$enclosure='"'<br />(string)$escape='\\'</td>
	<td>array</td>
	<td>Read and return file contents using custom formatting.</td>
</tr>
<tr>
	<td>readAsTsv</td>
	<td>(integer)$length=0<br />(string)$enclosure='"'<br />(string)$escape='\\'</td>
	<td>array</td>
	<td>Read and return file contents formatted as TSV.</td>
</tr>
<tr>
	<td>readChar</td>
	<td></td>
	<td>string</td>
	<td>Read and return the next single character in the file.</td>
</tr>
<tr>
	<td>readLine</td>
	<td>(integer)$length=False</td>
	<td>boolean</td>
	<td>Read and return a single line (maximum of $length bytes if specified,) from the file.</td>
</tr>
<tr>
	<td>removeLock</td>
	<td>(boolean)$would_block=False</td>
	<td>boolean</td>
	<td>Remove read or write locks placed on the file.</td>
</tr>
<tr>
	<td>rename</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Rename the file.</td>
</tr>
<tr>
	<td>rewindOffset</td>
	<td></td>
	<td>boolean</td>
	<td>Set the file pointer back to the beginning of the file.</td>
</tr>
<tr>
	<td>setOffset</td>
	<td>(integer)$offset</td>
	<td>boolean</td>
	<td>Set the file pointer to the specified byte offset.</td>
</tr>
<tr>
	<td>setReadLock</td>
	<td>(boolean)$would_block=False</td>
	<td>boolean</td>
	<td>Put a Read Lock on the file.</td>
</tr>
<tr>
	<td>setWriteLock</td>
	<td>(boolean)$would_block=False</td>
	<td>boolean</td>
	<td>Put a Write lock on the file.</td>
</tr>
<tr>
	<td>write</td>
	<td>(string)$data<br />(integer)$length=False</td>
	<td>boolean</td>
	<td>Write the data passed to the file.</td>
</tr>
</tbody></table>


Function Reference: FileHelper
-

All methods within this class should be called statically.

<table>
<thead><tr>
	<th>Function</th>
	<th>Arguments</th>
	<th>Returns</th>
	<th>Description</th>
</tr></thead><tbody>
<tr>
	<td>exists</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Whether or not the file or directory exists.</td>
</tr>
<tr>
	<td>getBaseName</td>
	<td>(string)$file_or_directory<br />(string)$suffix=False</td>
	<td>string</td>
	<td>Returns the base name of the file or directory.</td>
</tr>
<tr>
	<td>getDiscSpaceFree</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the amount of disc space free (in bytes).</td>
</tr>
<tr>
	<td>getDiscSpaceTotal</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the amount of disc space on the drive (in bytes).</td>
</tr>
<tr>
	<td>getDiscSpaceUsed</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the amount of disc space used (in bytes).</td>
</tr>
<tr>
	<td>getGroupId</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the ID of the group.</td>
</tr>
<tr>
	<td>getGroupName</td>
	<td>(string)$file_or_directory</td>
	<td>string</td>
	<td>Returns the name of the group.</td>
</tr>
<tr>
	<td>getInfo</td>
	<td>(string)$file_or_directory</td>
	<td>array</td>
	<td>Returns an array of information.</td>
</tr>
<tr>
	<td>getInode</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the inode.</td>
</tr>
<tr>
	<td>getLastAccessed</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the last accessed timestamp (if available).</td>
</tr>
<tr>
	<td>getLastModified</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the last modified timestamp.</td>
</tr>
<tr>
	<td>getOwnerId</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the ID of the owner.</td>
</tr>
<tr>
	<td>getOwnerName</td>
	<td>(string)$file_or_directory</td>
	<td>string</td>
	<td>Returns the name of the owner.</td>
</tr>
<tr>
	<td>getParentDirectory</td>
	<td>(string)$file_or_directory</td>
	<td>string</td>
	<td>Returns the parent directory.</td>
</tr>
<tr>
	<td>getPermissions</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the permissions.</td>
</tr>
<tr>
	<td>getSize</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Returns the size.
<tr>
	<td>getUmask</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the current umask.</td>
</tr>
<tr>
	<td>isDirectory</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Whether or not this is a directory.</td>
</tr>
<tr>
	<td>isExecutable</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Whether or not this is an executable file.</td>
</tr>
<tr>
	<td>isFile</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Whether or not this is a file.</td>
</tr>
<tr>
	<td>isLink</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Whether or not this is a symbolic link.</td>
</tr>
<tr>
	<td>isReadable</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Whether or not this is writable.</td>
</tr>
<tr>
	<td>isUploadedFile</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Whether or not this was uploaded.</td>
</tr>
<tr>
	<td>isWritable</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Whether or not this is writable.</td>
</tr>
<tr>
	<td>setGroupById</td>
	<td>(string)$file_or_directory<br />(integer)$group_id</td>
	<td>boolean</td>
	<td>Set the file's group.</td>
</tr>
<tr>
	<td>setGroupByName</td>
	<td>(string)$file_or_directory<br />(string)$group_name</td>
	<td>boolean</td>
	<td>Set the file's group.</td>
</tr>
<tr>
	<td>setOwnerById</td>
	<td>(string)$file_or_directory<br />(integer)$user_id</td>
	<td>boolean</td>
	<td>Set the file's owner.</td>
</tr>
<tr>
	<td>setOwnerByName</td>
	<td>(string)$file_or_directory<br />(string)$user_name</td>
	<td>boolean</td>
	<td>Set the file's owner.</td>
</tr>
<tr>
	<td>setPermissions</td>
	<td>(string)$file_or_directory</td>
	<td>boolean</td>
	<td>Set the file's permissions.</td>
</tr>
<tr>
	<td>setUmask</td>
	<td>(string)$file_or_directory</td>
	<td>integer</td>
	<td>Returns the current umask.</td>
</tr>
</tbody></table>

Example: Writing to a file
-

<pre>
&lt;?php
require 'file.class.php';

$file = new File('/path/to/file.txt', 'wb');
$file->write('First line of text');
$file->write('Second line of text');
$file->close();
</pre>

Example: Reading from a file
-

Using `foreach`, returning contents of file in chunks:
<pre>
&lt;?php
require 'file.class.php';

$file = new File('/path/to/file.txt', 'rb');
foreach($file as $chunk) {
	print $chunk . '&lt;br />';
}
$file->close();
</pre>

Using `while`, returning contents of file in chunks:
<pre>
&lt;?php
require 'file.class.php';

$file = new File('/path/to/file.txt', 'rb');
while($chunk = $file->read()) {
	print $chunk . '&lt;br />';
}
$file->close();
</pre>

Using `while`, returning contents of file in lines:
<pre>
&lt;?php
require 'file.class.php';

$file = new File('/path/to/file.txt', 'rb');
while($line = $file->readLine()) {
	print $line . '&lt;br />';
}
$file->close();
</pre>

Returning entire contents of file in a single call:
<pre>
&lt;?php
require 'file.class.php';

$file = new File('/path/to/file.txt', 'rb');
$contents = $file->readAll();
print $contents;
$file->close();
</pre>
