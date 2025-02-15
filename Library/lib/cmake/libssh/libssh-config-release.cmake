#----------------------------------------------------------------
# Generated CMake target import file for configuration "Release".
#----------------------------------------------------------------

# Commands may need to know the format version.
set(CMAKE_IMPORT_FILE_VERSION 1)

# Import target "ssh" for configuration "Release"
set_property(TARGET ssh APPEND PROPERTY IMPORTED_CONFIGURATIONS RELEASE)
set_target_properties(ssh PROPERTIES
  IMPORTED_LOCATION_RELEASE "${_IMPORT_PREFIX}/lib/libssh.4.8.8.dylib"
  IMPORTED_SONAME_RELEASE "@rpath/libssh.4.dylib"
  )

list(APPEND _IMPORT_CHECK_TARGETS ssh )
list(APPEND _IMPORT_CHECK_FILES_FOR_ssh "${_IMPORT_PREFIX}/lib/libssh.4.8.8.dylib" )

# Commands beyond this point should not need to know the version.
set(CMAKE_IMPORT_FILE_VERSION)
