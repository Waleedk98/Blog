// Chilkat Objective-C header.
// This is a generated header file for Chilkat version 9.5.0.93

// Generic/internal class name =  FileAccess
// Wrapped Chilkat C++ class name =  CkFileAccess

@class CkoBinData;
@class CkoStringBuilder;
@class CkoDateTime;


@interface CkoFileAccess : NSObject {

	@private
		void *m_obj;

}

- (id)init;
- (void)dealloc;
- (void)dispose;
- (NSString *)stringWithUtf8: (const char *)s;
- (void *)CppImplObj;
- (void)setCppImplObj: (void *)pObj;

- (void)clearCppImplObj;

@property (nonatomic, readonly, copy) NSString *CurrentDir;
@property (nonatomic, copy) NSString *DebugLogFilePath;
@property (nonatomic, readonly) BOOL EndOfFile;
@property (nonatomic, readonly, copy) NSNumber *FileOpenError;
@property (nonatomic, readonly, copy) NSString *FileOpenErrorMsg;
@property (nonatomic, readonly, copy) NSString *LastErrorHtml;
@property (nonatomic, readonly, copy) NSString *LastErrorText;
@property (nonatomic, readonly, copy) NSString *LastErrorXml;
@property (nonatomic) BOOL LastMethodSuccess;
@property (nonatomic) BOOL VerboseLogging;
@property (nonatomic, readonly, copy) NSString *Version;
// method: AppendAnsi
- (BOOL)AppendAnsi: (NSString *)text;
// method: AppendBd
- (BOOL)AppendBd: (CkoBinData *)bd;
// method: AppendSb
- (BOOL)AppendSb: (CkoStringBuilder *)sb 
	charset: (NSString *)charset;
// method: AppendText
- (BOOL)AppendText: (NSString *)text 
	charset: (NSString *)charset;
// method: AppendUnicodeBOM
- (BOOL)AppendUnicodeBOM;
// method: AppendUtf8BOM
- (BOOL)AppendUtf8BOM;
// method: DirAutoCreate
- (BOOL)DirAutoCreate: (NSString *)filePath;
// method: DirCreate
- (BOOL)DirCreate: (NSString *)path;
// method: DirDelete
- (BOOL)DirDelete: (NSString *)path;
// method: DirEnsureExists
- (BOOL)DirEnsureExists: (NSString *)dirPath;
// method: FileClose
- (void)FileClose;
// method: FileContentsEqual
- (BOOL)FileContentsEqual: (NSString *)path1 
	path2: (NSString *)path2;
// method: FileCopy
- (BOOL)FileCopy: (NSString *)existingPath 
	newPath: (NSString *)newPath 
	failIfExists: (BOOL)failIfExists;
// method: FileDelete
- (BOOL)FileDelete: (NSString *)path;
// method: FileExists
- (BOOL)FileExists: (NSString *)path;
// method: FileExists3
- (NSNumber *)FileExists3: (NSString *)path;
// method: FileOpen
- (BOOL)FileOpen: (NSString *)path 
	accessMode: (NSNumber *)accessMode 
	shareMode: (NSNumber *)shareMode 
	createDisp: (NSNumber *)createDisp 
	attr: (NSNumber *)attr;
// method: FileRead
- (NSData *)FileRead: (NSNumber *)numBytes;
// method: FileReadBd
- (BOOL)FileReadBd: (NSNumber *)maxNumBytes 
	binData: (CkoBinData *)binData;
// method: FileRename
- (BOOL)FileRename: (NSString *)existingPath 
	newPath: (NSString *)newPath;
// method: FileSeek
- (BOOL)FileSeek: (NSNumber *)offset 
	origin: (NSNumber *)origin;
// method: FileSize
- (NSNumber *)FileSize: (NSString *)path;
// method: FileSize64
- (NSNumber *)FileSize64: (NSString *)path;
// method: FileSizeStr
- (NSString *)FileSizeStr: (NSString *)filePath;
// method: FileType
- (NSNumber *)FileType: (NSString *)path;
// method: FileWrite
- (BOOL)FileWrite: (NSData *)data;
// method: FileWrite2
- (BOOL)FileWrite2: (NSData *)pByteData 
	szByteData: (NSNumber *)szByteData;
// method: FileWriteBd
- (BOOL)FileWriteBd: (CkoBinData *)binData 
	offset: (NSNumber *)offset 
	numBytes: (NSNumber *)numBytes;
// method: GenBlockId
- (NSString *)GenBlockId: (NSNumber *)index 
	length: (NSNumber *)length 
	encoding: (NSString *)encoding;
// method: GetDirectoryName
- (NSString *)GetDirectoryName: (NSString *)path;
// method: GetExtension
- (NSString *)GetExtension: (NSString *)path;
// method: GetFileName
- (NSString *)GetFileName: (NSString *)path;
// method: GetFileNameWithoutExtension
- (NSString *)GetFileNameWithoutExtension: (NSString *)path;
// method: GetFileTime
- (CkoDateTime *)GetFileTime: (NSString *)path 
	which: (NSNumber *)which;
// method: GetLastModified
- (CkoDateTime *)GetLastModified: (NSString *)path;
// method: GetNumBlocks
- (NSNumber *)GetNumBlocks: (NSNumber *)blockSize;
// method: GetTempFilename
- (NSString *)GetTempFilename: (NSString *)dirName 
	prefix: (NSString *)prefix;
// method: OpenForAppend
- (BOOL)OpenForAppend: (NSString *)filePath;
// method: OpenForRead
- (BOOL)OpenForRead: (NSString *)filePath;
// method: OpenForReadWrite
- (BOOL)OpenForReadWrite: (NSString *)filePath;
// method: OpenForWrite
- (BOOL)OpenForWrite: (NSString *)filePath;
// method: ReadBinaryToEncoded
- (NSString *)ReadBinaryToEncoded: (NSString *)path 
	encoding: (NSString *)encoding;
// method: ReadBlock
- (NSData *)ReadBlock: (NSNumber *)blockIndex 
	blockSize: (NSNumber *)blockSize;
// method: ReadBlockBd
- (BOOL)ReadBlockBd: (NSNumber *)blockIndex 
	blockSize: (NSNumber *)blockSize 
	bd: (CkoBinData *)bd;
// method: ReadEntireFile
- (NSData *)ReadEntireFile: (NSString *)path;
// method: ReadEntireTextFile
- (NSString *)ReadEntireTextFile: (NSString *)path 
	charset: (NSString *)charset;
// method: ReadNextFragment
- (NSNumber *)ReadNextFragment: (BOOL)startAtBeginning 
	beginMarker: (NSString *)beginMarker 
	endMarker: (NSString *)endMarker 
	charset: (NSString *)charset 
	sb: (CkoStringBuilder *)sb;
// method: ReassembleFile
- (BOOL)ReassembleFile: (NSString *)partsDirPath 
	partPrefix: (NSString *)partPrefix 
	partExtension: (NSString *)partExtension 
	reassembledFilename: (NSString *)reassembledFilename;
// method: ReplaceStrings
- (NSNumber *)ReplaceStrings: (NSString *)path 
	charset: (NSString *)charset 
	existing: (NSString *)existing 
	replacementString: (NSString *)replacementString;
// method: SaveLastError
- (BOOL)SaveLastError: (NSString *)path;
// method: SetCurrentDir
- (BOOL)SetCurrentDir: (NSString *)path;
// method: SetFileTimes
- (BOOL)SetFileTimes: (NSString *)path 
	create: (CkoDateTime *)create 
	lastAccess: (CkoDateTime *)lastAccess 
	lastModified: (CkoDateTime *)lastModified;
// method: SetLastModified
- (BOOL)SetLastModified: (NSString *)path 
	lastModified: (CkoDateTime *)lastModified;
// method: SplitFile
- (BOOL)SplitFile: (NSString *)fileToSplit 
	partPrefix: (NSString *)partPrefix 
	partExtension: (NSString *)partExtension 
	partSize: (NSNumber *)partSize 
	destDir: (NSString *)destDir;
// method: SymlinkCreate
- (BOOL)SymlinkCreate: (NSString *)targetPath 
	linkPath: (NSString *)linkPath;
// method: SymlinkTarget
- (NSString *)SymlinkTarget: (NSString *)linkPath;
// method: TreeDelete
- (BOOL)TreeDelete: (NSString *)path;
// method: Truncate
- (BOOL)Truncate;
// method: WriteEntireFile
- (BOOL)WriteEntireFile: (NSString *)path 
	fileData: (NSData *)fileData;
// method: WriteEntireTextFile
- (BOOL)WriteEntireTextFile: (NSString *)path 
	fileData: (NSString *)fileData 
	charset: (NSString *)charset 
	includePreamble: (BOOL)includePreamble;

@end
