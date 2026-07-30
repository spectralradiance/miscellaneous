package boniface;

import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.Properties;
import javafx.scene.control.SplitPane;
import javafx.stage.Stage;

// http://www.mkyong.com/java/java-properties-file-examples/
public class ProgramProperties
{
	public static String database_path = null;
	public static String last_word = null;
	public static double window_x = -1, window_y = -1;
	public static double window_width = -1, window_height = -1;
	public static double slider_pos = -1;
	public static void load()
	{
		try (InputStream input = new FileInputStream("config.properties"))
		{
			Properties prop = new Properties();
			prop.load(input);
			database_path = prop.getProperty("database_path", "");
			last_word = prop.getProperty("last_word", "");
			window_x = Double.parseDouble(prop.getProperty("window_x", "-1"));
			window_y = Double.parseDouble(prop.getProperty("window_y", "-1"));
			window_width = Double.parseDouble(prop.getProperty("window_width", "-1"));
			window_height = Double.parseDouble(prop.getProperty("window_height", "-1"));
			slider_pos = Double.parseDouble(prop.getProperty("slider_pos", "-1"));
		}
		catch (Exception ex)
		{
			// probable the file doesn't exist, and will be created on exit
		}
	}
	public static void save()
	{
		try (OutputStream output = new FileOutputStream("config.properties"))
		{
			Properties prop = new Properties();
			prop.setProperty("database_path", database_path);
			prop.setProperty("last_word", last_word);
			prop.setProperty("window_x", Double.toString(window_x));
			prop.setProperty("window_y", Double.toString(window_y));
			prop.setProperty("window_width", Double.toString(window_width));
			prop.setProperty("window_height", Double.toString(window_height));
			prop.setProperty("slider_pos", Double.toString(slider_pos));
			prop.store(output, null);
		}
		catch (Exception ex)
		{
			ex.printStackTrace();
		}
	}
}
