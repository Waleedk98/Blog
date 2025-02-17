// Chilkat Objective-C header.
// This is a generated header file for Chilkat version 9.5.0.93

// Generic/internal class name =  MessageSet
// Wrapped Chilkat C++ class name =  CkMessageSet

@class CkoTask;


@interface CkoMessageSet : NSObject {

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

@property (nonatomic, readonly, copy) NSNumber *Count;
@property (nonatomic) BOOL HasUids;
@property (nonatomic) BOOL LastMethodSuccess;
// method: ContainsId
- (BOOL)ContainsId: (NSNumber *)id;
// method: FromCompactString
- (BOOL)FromCompactString: (NSString *)str;
// method: GetId
- (NSNumber *)GetId: (NSNumber *)index;
// method: InsertId
- (void)InsertId: (NSNumber *)id;
// method: LoadTaskResult
- (BOOL)LoadTaskResult: (CkoTask *)task;
// method: RemoveId
- (void)RemoveId: (NSNumber *)id;
// method: ToCommaSeparatedStr
- (NSString *)ToCommaSeparatedStr;
// method: ToCompactString
- (NSString *)ToCompactString;

@end
