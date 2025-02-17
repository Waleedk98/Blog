// Chilkat Objective-C header.
// This is a generated header file for Chilkat version 9.5.0.93

// Generic/internal class name =  Csr
// Wrapped Chilkat C++ class name =  CkCsr

@class CkoPrivateKey;
@class CkoBinData;
@class CkoXml;
@class CkoPublicKey;
@class CkoStringTable;


@interface CkoCsr : NSObject {

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

@property (nonatomic, copy) NSString *CommonName;
@property (nonatomic, copy) NSString *Company;
@property (nonatomic, copy) NSString *CompanyDivision;
@property (nonatomic, copy) NSString *Country;
@property (nonatomic, copy) NSString *DebugLogFilePath;
@property (nonatomic, copy) NSString *EmailAddress;
@property (nonatomic, copy) NSString *HashAlgorithm;
@property (nonatomic, readonly, copy) NSString *LastErrorHtml;
@property (nonatomic, readonly, copy) NSString *LastErrorText;
@property (nonatomic, readonly, copy) NSString *LastErrorXml;
@property (nonatomic) BOOL LastMethodSuccess;
@property (nonatomic, copy) NSString *Locality;
@property (nonatomic, copy) NSString *MgfHashAlg;
@property (nonatomic) BOOL PssPadding;
@property (nonatomic, copy) NSString *State;
@property (nonatomic) BOOL VerboseLogging;
@property (nonatomic, readonly, copy) NSString *Version;
// method: AddSan
- (BOOL)AddSan: (NSString *)sanType 
	sanValue: (NSString *)sanValue;
// method: GenCsrBd
- (BOOL)GenCsrBd: (CkoPrivateKey *)privKey 
	csrData: (CkoBinData *)csrData;
// method: GenCsrPem
- (NSString *)GenCsrPem: (CkoPrivateKey *)privKey;
// method: GetExtensionRequest
- (BOOL)GetExtensionRequest: (CkoXml *)extensionReqXml;
// method: GetPublicKey
- (BOOL)GetPublicKey: (CkoPublicKey *)pubkey;
// method: GetSans
- (BOOL)GetSans: (CkoStringTable *)sans;
// method: GetSubjectField
- (NSString *)GetSubjectField: (NSString *)oid;
// method: LoadCsrPem
- (BOOL)LoadCsrPem: (NSString *)csrPemStr;
// method: SaveLastError
- (BOOL)SaveLastError: (NSString *)path;
// method: SetExtensionRequest
- (BOOL)SetExtensionRequest: (CkoXml *)extensionReqXml;
// method: SetSubjectField
- (BOOL)SetSubjectField: (NSString *)oid 
	value: (NSString *)value 
	asnType: (NSString *)asnType;
// method: VerifyCsr
- (BOOL)VerifyCsr;

@end
