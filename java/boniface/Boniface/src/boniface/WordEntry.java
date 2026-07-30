package boniface;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

public class WordEntry implements Comparable<String>
{
	public String word;
	public String description;
	public String associations;
	public String tags;
	public WordEntry(String word, String description, String associations, String tags)
	{
		this.word = word;
		this.description = description;
		this.associations = associations;
		this.tags = tags;
	}
	public String toString()
	{
		return word;
	}
	
	public int compareTo(String s)
	{
		return word.compareTo(s);
	}
	
	public static ObservableList<String> toList(String s)
	{
		if (s.equals(""))
		{
			return FXCollections.observableArrayList();
		}
		return FXCollections.observableArrayList(Arrays.asList(s.split(",")));
	}
	public static String toString(ObservableList<String> o)
	{
		return String.join(",", o);
	}
}
