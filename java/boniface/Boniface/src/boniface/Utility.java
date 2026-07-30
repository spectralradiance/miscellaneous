package boniface;

import java.awt.Desktop;
import java.io.File;
import java.net.URL;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

public class Utility
{
	public static boolean fileExists(String path)
	{
		File file = new File(path);
		return file.exists();
	}
	public static String dateAsFileName()
	{
		Date date = new Date();
		DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd-hh-mm-ss");
		return dateFormat.format(date);
	}
	public static void openWebpage(String url) throws Exception
	{
		if (Desktop.isDesktopSupported())
		{
			Desktop desktop = Desktop.getDesktop();
			if (desktop.isSupported(Desktop.Action.BROWSE))
			{
				URL t = new URL(url);
				desktop.browse(t.toURI());
			}
		}
	}
}
