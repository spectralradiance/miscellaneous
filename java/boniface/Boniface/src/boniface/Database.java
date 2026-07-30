package boniface;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import javafx.collections.ObservableList;

public class Database
{
	public final String path;
	public Database(String path)
	{
		this.path = path;
	}
	public Connection createConnection() throws SQLException
	{
		return DriverManager.getConnection("jdbc:sqlite:"+path);
	}
	public void createDatabase() throws SQLException
	{
		String sql = "CREATE TABLE Words ("
                + "ID INTEGER PRIMARY KEY,"
                + "Word text NOT NULL,"
                + "Description text NOT NULL,"
				+ "Associations text NOT NULL,"
				+ "Tags text NOT NULL);";
		Connection c = createConnection();
		Statement s = c.createStatement();
		s.execute(sql);
		s.close();
		c.close();
	}
	
	public ArrayList<String> loadWords(ObservableList<WordEntry> words) throws SQLException
	{
		String sql = "SELECT * from Words ORDER BY Word ASC";
		Connection c = createConnection();
		Statement s = c.createStatement();
		ResultSet rs = s.executeQuery(sql);
		ArrayList<String> r = new ArrayList<String>();
		while (rs.next())
		{
			String word = rs.getString("Word");
			String description = rs.getString("description");
			String associations = rs.getString("associations");
			String tags = rs.getString("tags");
			words.add(new WordEntry(word, description, associations, tags));
		}
		rs.close();
		s.close();
		c.close();
		return r;
	}
	
	public WordEntry getEntry(String word) throws SQLException
	{
		String sql = "SELECT * FROM Words WHERE Word=? LIMIT 1";
		Connection c = createConnection();
		PreparedStatement ps = c.prepareStatement(sql);
		ps.setString(1, word);
		ResultSet rs = ps.executeQuery();
		if (rs.next())
		{
			String description = rs.getString("Description");
			String associations = rs.getString("Associations");
			String tags = rs.getString("Tags");
			rs.close();
			ps.close();
			c.close();
			return new WordEntry(word, description, associations, tags);
		}
		return null;
	}
	
	public void createEntry(WordEntry entry) throws SQLException
	{
		// code invoking this should check whether the word already exists
		String sql = "INSERT INTO Words (ID, Word, Description, Associations, Tags) VALUES(NULL,?,?,?,?)";
		Connection c = createConnection();
		PreparedStatement ps = c.prepareStatement(sql);
		ps.setString(1, entry.word);
		ps.setString(2, entry.description);
		ps.setString(3, entry.associations);
		ps.setString(4, String.join(",", entry.tags));
		ps.execute();
		ps.close();
		c.close();
	}
	
	public void editEntry(String old_word, WordEntry entry) throws SQLException
	{
		// code invoking this should check whether the word already exists
		String sql = "UPDATE Words SET Word=?, Description=?, Associations=?, Tags=? WHERE Word=?";
		Connection c = createConnection();
		PreparedStatement ps = c.prepareStatement(sql);
		ps.setString(1, entry.word);
		ps.setString(2, entry.description);
		ps.setString(3, entry.associations);
		ps.setString(4, entry.tags);
		ps.setString(5, old_word);
		ps.execute();
		ps.close();
		c.close();
	}
	public void deleteEntry(String word) throws SQLException
	{
		String sql = "DELETE FROM Words WHERE Word=?";
		Connection c = createConnection();
		PreparedStatement ps = c.prepareStatement(sql);
		ps.setString(1, word);
		ps.execute();
		ps.close();
		c.close();
	}
	
	// maybe in the future, read incrementally
	// a few thousand words shouldn't matter though
	public void exportToHTML(String path) throws IOException, SQLException
	{
		BufferedWriter bw = new BufferedWriter(new FileWriter(path));
		bw.write("<html>\n\t<body>");
		
		Connection c = createConnection();
		String sql = "SELECT * from Words ORDER BY Word ASC";
		Statement s = c.createStatement();
		ResultSet rs = s.executeQuery(sql);
		while (rs.next())
		{
			String word = rs.getString("Word");
			String description = rs.getString("Description");
			String associations = rs.getString("Associations");
			String tags = rs.getString("Tags");

			String html = "<h3>"+word+"</h3>\n"
							+ "<p>"+description+"</p>\n"
							+ "<p>Associations: "+associations+"</p>"
							+ "<p>Tags: "+tags+"</p>\n";
			bw.write(html);
		}
		rs.close();
		s.close();
		c.close();
		
		bw.write("</body></html>");
		bw.close();
	}
	
	public void exportToCSV(String path) throws IOException, SQLException
	{
		BufferedWriter bw = new BufferedWriter(new FileWriter(path));
		bw.write("word,description,associations,tags");
		
		Connection c = createConnection();
		String sql = "SELECT * from Words ORDER BY Word ASC";
		Statement s = c.createStatement();
		ResultSet rs = s.executeQuery(sql);
		while (rs.next())
		{
			String word = rs.getString("Word");
			String description = rs.getString("Description");
			String associations = rs.getString("Associations");
			String tags = rs.getString("Tags");
			
			associations = associations.replace(',', ' ');
			tags = tags.replace(',', ' ');

			String csv = word+","+description+","+associations+","+tags+"\n";
			bw.write(csv);
		}
		rs.close();
		s.close();
		c.close();
		
		bw.close();
	}
	
	public void exportToTXT(String path) throws IOException, SQLException
	{
		BufferedWriter bw = new BufferedWriter(new FileWriter(path));
		
		Connection c = createConnection();
		String sql = "SELECT * from Words ORDER BY Word ASC";
		Statement s = c.createStatement();
		ResultSet rs = s.executeQuery(sql);
		while (rs.next())
		{
			String word = rs.getString("Word");
			String description = rs.getString("Description");
			String associations = rs.getString("Associations");
			String tags = rs.getString("Tags");

			String txt = word+"\n\t"+description+"\n\tAssociations:"+associations+"\n\tTags:"+tags+"\n";
			bw.write(txt);
		}
		rs.close();
		s.close();
		c.close();
		
		bw.close();
	}
}
