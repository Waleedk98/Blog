// Chilkat Objective-C header.
// This is a generated header file for Chilkat version 9.5.0.93

// Generic/internal class name =  SCard
// Wrapped Chilkat C++ class name =  CkSCard

@class CkoJsonObject;
@class CkoBinData;
@class CkoStringTable;
@class CkoTask;


@class CkoBaseProgress;

@interface CkoSCard : NSObject {

	@private
		void *m_eventCallback;
		void *m_obj;

}

- (id)init;
- (void)dealloc;
- (void)dispose;
- (NSString *)stringWithUtf8: (const char *)s;
- (void *)CppImplObj;
- (void)setCppImplObj: (void *)pObj;

- (void)clearCppImplObj;

// property setter: EventCallbackObject
- (void)setEventCallbackObject: (CkoBaseProgress *)eventObj;

@property (nonatomic, readonly, copy) NSString *ActiveProtocol;
@property (nonatomic, readonly, copy) NSString *CardAtr;
@property (nonatomic, readonly, copy) NSString *ConnectedReader;
@property (nonatomic, readonly, copy) NSString *Context;
@property (nonatomic, copy) NSString *DebugLogFilePath;
@property (nonatomic, readonly, copy) NSString *LastErrorHtml;
@property (nonatomic, readonly, copy) NSString *LastErrorText;
@property (nonatomic, readonly, copy) NSString *LastErrorXml;
@property (nonatomic) BOOL LastMethodSuccess;
@property (nonatomic, copy) NSString *PcscLibPath;
@property (nonatomic, readonly, copy) NSString *ReaderStatus;
@property (nonatomic, readonly, copy) NSString *ScardError;
@property (nonatomic) BOOL VerboseLogging;
@property (nonatomic, readonly, copy) NSString *Version;
// method: BeginTransaction
- (BOOL)BeginTransaction;
// method: CheckStatus
- (BOOL)CheckStatus;
// method: Connect
- (BOOL)Connect: (NSString *)reader 
	shareMode: (NSString *)shareMode 
	preferredProtocol: (NSString *)preferredProtocol;
// method: Disconnect
- (BOOL)Disconnect: (NSString *)disposition;
// method: EndTransaction
- (BOOL)EndTransaction: (NSString *)disposition;
// method: EstablishContext
- (BOOL)EstablishContext: (NSString *)scope;
// method: FindSmartcards
- (BOOL)FindSmartcards: (CkoJsonObject *)json;
// method: GetAttrib
- (BOOL)GetAttrib: (NSString *)attr 
	bd: (CkoBinData *)bd;
// method: GetAttribStr
- (NSString *)GetAttribStr: (NSString *)attr;
// method: GetAttribUint
- (NSNumber *)GetAttribUint: (NSString *)attr;
// method: GetStatusChange
- (BOOL)GetStatusChange: (NSNumber *)maxWaitMs 
	stReaderNames: (CkoStringTable *)stReaderNames 
	json: (CkoJsonObject *)json;
// method: GetStatusChangeAsync
- (CkoTask *)GetStatusChangeAsync: (NSNumber *)maxWaitMs 
	stReaderNames: (CkoStringTable *)stReaderNames 
	json: (CkoJsonObject *)json;
// method: GetStatusChangeCancel
- (BOOL)GetStatusChangeCancel;
// method: ListReaderGroups
- (BOOL)ListReaderGroups: (CkoStringTable *)readerGroups;
// method: ListReaders
- (BOOL)ListReaders: (CkoStringTable *)st;
// method: Reconnect
- (BOOL)Reconnect: (NSString *)shareMode 
	preferredProtocol: (NSString *)preferredProtocol 
	action: (NSString *)action;
// method: ReleaseContext
- (BOOL)ReleaseContext;
// method: SaveLastError
- (BOOL)SaveLastError: (NSString *)path;
// method: SendControl
- (BOOL)SendControl: (NSNumber *)controlCode 
	bdSend: (CkoBinData *)bdSend 
	bdRecv: (CkoBinData *)bdRecv;
// method: SendControlHex
- (BOOL)SendControlHex: (NSNumber *)controlCode 
	sendData: (NSString *)sendData 
	bdRecv: (CkoBinData *)bdRecv;
// method: Transmit
- (BOOL)Transmit: (NSString *)protocol 
	bdSend: (CkoBinData *)bdSend 
	bdRecv: (CkoBinData *)bdRecv 
	maxRecvLen: (NSNumber *)maxRecvLen;
// method: TransmitHex
- (BOOL)TransmitHex: (NSString *)protocol 
	apduHex: (NSString *)apduHex 
	bdRecv: (CkoBinData *)bdRecv 
	maxRecvLen: (NSNumber *)maxRecvLen;

@end
