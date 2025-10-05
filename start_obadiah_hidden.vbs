' Run start_obadiah.bat hidden (no console window)
Dim fso, shell, folder, cmd
Set fso = CreateObject("Scripting.FileSystemObject")
Set shell = CreateObject("WScript.Shell")
folder = fso.GetParentFolderName(WScript.ScriptFullName)
cmd = Chr(34) & folder & "\start_obadiah.bat" & Chr(34)
shell.Run cmd, 0 ' 0 = hidden
Set shell = Nothing
Set fso = Nothing
