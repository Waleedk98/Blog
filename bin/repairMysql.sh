#!/bin/sh

BPATH="/Applications/MAMP/tmp/mysql/.mysqlBranch"
if [[ -f ${BPATH} && -r ${BPATH} ]]; then
	MYBRANCH=`cat "${BPATH}"`
	if ! [[ ${MYBRANCH} == "57" ]] && ! [[ ${MYBRANCH} == "80" ]]; then
		MYBRANCH="57"
	fi
else
	MYBRANCH="57"
fi

/Applications/MAMP/Library/bin/mysql${MYBRANCH}/bin/mysqlcheck --all-databases --repair -u root -proot --socket=/Applications/MAMP/tmp/mysql/mysql.sock
