@ echo off
:first_arg
if %1 == new (
	if %2 == Controller (
		CALL :CreateController %3
		goto EOF
	)
	if %2 == View (
		CALL :CreateView %3
		goto EOF
	)
	if %2 == ControllerView (
		CALL :CreateController %3
		CALL :CreateView %3
		goto EOF
	) else (
		echo Unknown "new" command
		goto EOF
	)
	goto EOF
	
) else (
	echo Unknown command
	goto EOF
)

:EOF
EXIT /B %ERRORLEVEL%

:CreateController 
echo Creating new Controller .... %~1
cd app\controllers
(for /F "tokens=* USEBACKQ" %%A in (`dir *.php /b`) do (
	if %%A ==  %~1.php ( 
		echo Controller %~1 Exists
		goto FAILED_CONTROLLER
	)

	) )
setlocal EnableExtensions EnableDelayedExpansion
set "INTEXTFILE=Home.php"
set "OUTTEXTFILE=%~1.php"
set "SEARCHTEXT=home"
set "REPLACETEXT=%~1"

for /f "delims=" %%A in ('type "%INTEXTFILE%"') do (
    set "string=%%A"
    set "modified=!string:%SEARCHTEXT%=%REPLACETEXT%!"
    echo !modified!>>"%OUTTEXTFILE%"
)
endlocal
:FAILED_CONTROLLER
cd ..\..
EXIT /B 8
:CreateView 
echo Creating new View .... %~1
cd app\views
(for /F "tokens=* USEBACKQ" %%A in (`dir *.php /b`) do (
	if %%A ==  %~1.php ( 
		echo View %~1 Exists
		goto FAILED_VIEW
	)

	) )
setlocal EnableExtensions EnableDelayedExpansion
set "INTEXTFILE=home.php"
set "OUTTEXTFILE=%~1.php"
set "SEARCHTEXT=home"
set "REPLACETEXT=%~1"

for /f "delims=" %%A in ('type "%INTEXTFILE%"') do (
    set "string=%%A"
    set "modified=!string:%SEARCHTEXT%=%REPLACETEXT%!"
    echo !modified!>>"%OUTTEXTFILE%"
)
endlocal
:FAILED_VIEW
cd ..\..
EXIT /B 9