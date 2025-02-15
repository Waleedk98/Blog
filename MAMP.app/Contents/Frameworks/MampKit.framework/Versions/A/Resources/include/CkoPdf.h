// Chilkat Objective-C header.
// This is a generated header file for Chilkat version 9.5.0.93

// Generic/internal class name =  Pdf
// Wrapped Chilkat C++ class name =  CkPdf

@class CkoCert;
@class CkoJsonObject;
@class CkoTask;
@class CkoStringBuilder;
@class CkoBinData;
@class CkoHttp;
@class CkoPrivateKey;


@class CkoBaseProgress;

@interface CkoPdf : NSObject {

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

@property (nonatomic, copy) NSString *DebugLogFilePath;
@property (nonatomic, readonly, copy) NSString *LastErrorHtml;
@property (nonatomic, readonly, copy) NSString *LastErrorText;
@property (nonatomic, readonly, copy) NSString *LastErrorXml;
@property (nonatomic) BOOL LastMethodSuccess;
@property (nonatomic, readonly, copy) NSNumber *NumPages;
@property (nonatomic, readonly, copy) NSNumber *NumSignatures;
@property (nonatomic, copy) NSNumber *SigAllocateSize;
@property (nonatomic, copy) NSString *UncommonOptions;
@property (nonatomic) BOOL VerboseLogging;
@property (nonatomic, readonly, copy) NSString *Version;
// method: AddSigningCert
- (BOOL)AddSigningCert: (CkoCert *)cert;
// method: AddVerificationInfo
- (BOOL)AddVerificationInfo: (CkoJsonObject *)jsonOptions 
	outFilePath: (NSString *)outFilePath;
// method: AddVerificationInfoAsync
- (CkoTask *)AddVerificationInfoAsync: (CkoJsonObject *)jsonOptions 
	outFilePath: (NSString *)outFilePath;
// method: GetDss
- (BOOL)GetDss: (CkoJsonObject *)json;
// method: GetMetadata
- (BOOL)GetMetadata: (CkoStringBuilder *)sb;
// method: GetSignatureContent
- (BOOL)GetSignatureContent: (NSNumber *)index 
	bd: (CkoBinData *)bd;
// method: GetSignerCert
- (BOOL)GetSignerCert: (NSNumber *)index 
	cert: (CkoCert *)cert;
// method: GetUnsignedSigFields
- (BOOL)GetUnsignedSigFields: (CkoJsonObject *)json;
// method: LastJsonData
- (CkoJsonObject *)LastJsonData;
// method: LoadBd
- (BOOL)LoadBd: (CkoBinData *)pdfData;
// method: LoadFile
- (BOOL)LoadFile: (NSString *)filePath;
// method: SaveLastError
- (BOOL)SaveLastError: (NSString *)path;
// method: SetHttpObj
- (void)SetHttpObj: (CkoHttp *)http;
// method: SetSignatureJpeg
- (BOOL)SetSignatureJpeg: (CkoBinData *)jpgData;
// method: SetSigningCert
- (BOOL)SetSigningCert: (CkoCert *)cert;
// method: SetSigningCert2
- (BOOL)SetSigningCert2: (CkoCert *)cert 
	privateKey: (CkoPrivateKey *)privateKey;
// method: SignPdf
- (BOOL)SignPdf: (CkoJsonObject *)jsonOptions 
	outFilePath: (NSString *)outFilePath;
// method: SignPdfAsync
- (CkoTask *)SignPdfAsync: (CkoJsonObject *)jsonOptions 
	outFilePath: (NSString *)outFilePath;
// method: VerifySignature
- (BOOL)VerifySignature: (NSNumber *)index 
	sigInfo: (CkoJsonObject *)sigInfo;

@end
