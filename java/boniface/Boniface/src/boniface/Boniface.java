package boniface;

import java.io.File;
import java.sql.SQLException;
import java.util.Collections;
import java.util.Optional;
import javafx.animation.KeyFrame;
import javafx.animation.Timeline;
import javafx.application.Application;
import javafx.application.Platform;
import javafx.beans.value.ObservableValue;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.collections.transformation.FilteredList;
import javafx.event.ActionEvent;
import javafx.geometry.Insets;
import javafx.geometry.Orientation;
import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.ButtonType;
import javafx.scene.control.ContentDisplay;
import javafx.scene.control.Dialog;
import javafx.scene.control.Label;
import javafx.scene.control.ListView;
import javafx.scene.control.Menu;
import javafx.scene.control.MenuBar;
import javafx.scene.control.MenuItem;
import javafx.scene.control.SelectionMode;
import javafx.scene.control.SeparatorMenuItem;
import javafx.scene.control.SplitPane;
import javafx.scene.control.TextArea;
import javafx.scene.control.TextField;
import javafx.scene.control.TextInputDialog;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.Pane;
import javafx.scene.layout.Priority;
import javafx.scene.layout.VBox;
import javafx.scene.text.Font;
import javafx.stage.FileChooser;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import javafx.util.Duration;

public class Boniface extends Application
{
	
	private Stage primary_stage;
	private Scene scene;
	private ListView<WordEntry> list_view;
	private TextField filter_input;
	private VBox pane_load_lexicon;
	private BorderPane pane_main;
	private SplitPane split_pane;
	
	private BorderPane pane_view_entry;
	private Label label_word;
	private Label label_description;
	private ListView<String> ass_view, tag_view;
	
	private BorderPane pane_edit_entry;
	private TextField input_word;
	private TextArea input_description;
	private ListView ass_edit, tag_edit;
	
	
	private Database lexicon;
	private ObservableList<WordEntry> words;
	private WordEntry current_entry;
	
	private Timeline timeline = null;
	
	
	// this does NOT use PropgramProperties.last_word
	// because the words first have to be read from the database
	// so selecting the last-viewed word must be handled after calling this
	private void loadProperties()
	{
		ProgramProperties.load();
		
		if (ProgramProperties.window_x != -1) primary_stage.setX(ProgramProperties.window_x);
		if (ProgramProperties.window_y != -1) primary_stage.setY(ProgramProperties.window_y);
		if (ProgramProperties.window_width != -1) primary_stage.setWidth(ProgramProperties.window_width);
		if (ProgramProperties.window_height != -1) primary_stage.setHeight(ProgramProperties.window_height);
		if (ProgramProperties.slider_pos != -1) split_pane.setDividerPosition(0, 2*ProgramProperties.slider_pos);
		
	}
	
	public void saveProperties()
	{
		if (lexicon != null)
		{
			ProgramProperties.database_path = lexicon.path;
		}
		
		if (current_entry != null)
		{
			ProgramProperties.last_word = current_entry.word;
		}
		
		ProgramProperties.window_x = primary_stage.getX();
		ProgramProperties.window_y = primary_stage.getY();
		ProgramProperties.window_width = primary_stage.getWidth();
		ProgramProperties.window_height = primary_stage.getHeight();
		ProgramProperties.slider_pos = split_pane.getDividerPositions()[0];
		
		ProgramProperties.save();
	}
	
	
	private boolean isEditing()
	{
		return split_pane.getItems().get(1) == pane_edit_entry;
	}
	private int findIndex(String word)
	{
		return Collections.binarySearch(words, word);
	}
	private int findInsertionIndex(String word) // TODO: replace with binary search
	{
		//int index = 0;
		//while (index < words.size() && words.get(index).word.compareToIgnoreCase(current_entry.word) < 0) ++index;
		//return index;
		return -Collections.binarySearch(words, word)-1;
	}
	private boolean hasWord(String word)
	{
		return Collections.binarySearch(words, word) >= 0;
	}
	
	private void createDatabase()
	{
		FileChooser file_chooser = new FileChooser();
		file_chooser.setTitle("Save Lexicon Database");
		FileChooser.ExtensionFilter file_filter = new FileChooser.ExtensionFilter("DB files (*.db)", "*.db");
		file_chooser.getExtensionFilters().add(file_filter);
		File db_file = file_chooser.showSaveDialog(primary_stage);
		if (db_file != null)
		{
			try
			{
				clearData();
				lexicon = new Database(db_file.getAbsolutePath());
				lexicon.createDatabase();
				loadWords();
			}
			catch (Exception ex)
			{
				Alert alert = new Alert(AlertType.ERROR, "Error Creating Database: "+ex.getMessage());
				alert.setHeaderText(null);
				alert.showAndWait();
			}
		}
	}
	
	
	public void clearData()
	{
		current_entry = null;
		refreshEntryView();
		refreshEntryEdit();
		words.clear();
		lexicon = null;
	}
	

	
	private void openDatabase()
	{
		FileChooser file_chooser = new FileChooser();
		file_chooser.setTitle("Open Lexicon Database");
		FileChooser.ExtensionFilter file_filter = new FileChooser.ExtensionFilter("DB files (*.db)", "*.db");
		file_chooser.getExtensionFilters().add(file_filter);
		File db_file = file_chooser.showOpenDialog(primary_stage);
		if (db_file != null)
		{
			try
			{
				clearData();
				lexicon = new Database(db_file.getAbsolutePath());
				loadWords();
			}
			catch (Exception ex)
			{
				Alert alert = new Alert(AlertType.ERROR, "Error Opening Database: "+ex.getMessage());
				alert.setHeaderText(null);
				alert.showAndWait();
			}
		}
	}
	
	
	private void buildIntroPane()
	{
		// create intro pane for creating/opening a lexicon database
		pane_load_lexicon = new VBox(20);
		Button btn_new = new Button("Create New Lexicon");
		btn_new.setOnAction((ActionEvent event) ->
		{
			createDatabase();
			scene.setRoot(pane_main);
		});
		Button btn_open = new Button("Open Existing Lexicon");
		btn_open.setOnAction((ActionEvent event) ->
		{
			openDatabase();
			scene.setRoot(pane_main);
		});
		pane_load_lexicon.getChildren().addAll(btn_new, btn_open);
        pane_load_lexicon.setAlignment(Pos.CENTER);
	}
	
	
	private MenuBar buildMenuBar()
	{
		MenuBar menu_bar = new MenuBar();
		
		Menu mw = new Menu("Words");
		MenuItem mw_new = new MenuItem("New Word");
		mw_new.setOnAction(actionEvent -> {
			current_entry = null;
			refreshEntryEdit();
			split_pane.getItems().set(1, pane_edit_entry);
			input_word.requestFocus();
		});
		
		MenuItem mw_delete = new MenuItem("Delete Word");
		mw_delete.setOnAction(actionEvent -> {
			if (current_entry != null)
			{
				Alert cd = new Alert(AlertType.CONFIRMATION, "Are you sure you want to delete '"+current_entry.word+"'?");
				cd.setHeaderText(null);
				Optional<ButtonType> result = cd.showAndWait();
				if (result.get() == ButtonType.OK)
				{
					try
					{
						lexicon.deleteEntry(current_entry.word);
						int index = findIndex(current_entry.word);
						words.remove(index);
						current_entry = null;
						list_view.getSelectionModel().selectFirst();
					}
					catch (SQLException ex)
					{
						Alert alert = new Alert(AlertType.ERROR, "Error Deleting Entry: "+ex.getMessage());
						alert.setHeaderText(null);
						alert.showAndWait();
					}
				}
			}
			else
			{
				Alert alert = new Alert(AlertType.WARNING, "No word selected!");
				alert.setHeaderText(null);
				alert.showAndWait();
			}
		});
		MenuItem mw_close = new MenuItem("Close");
		mw_close.setOnAction(actionEvent -> {
			saveProperties();
			Platform.exit();
		});
		mw.getItems().addAll(mw_new, mw_delete, new SeparatorMenuItem(), mw_close);
		
		
		
		Lookup[] lookups = new Lookup[]{
			new Lookup("wiktionary.org", "https://en.wiktionary.org/wiki/%1s"),
			new Lookup("etymonline.com", "http://www.etymonline.com/index.php?allowed_in_frame=0&search=%1s"),
			new Lookup("rhymezone.com", "http://www.rhymezone.com/r/rhyme.cgi?Word=%1s&typeofrhyme=perfect&org1=syl&org2=l&org3=y"),
			null,
			new Lookup("oxforddictionaries.com", "https://en.oxforddictionaries.com/definition/us/%1s"),
			new Lookup("oxforddictionaries.com/thesaurus", "https://en.oxforddictionaries.com/thesaurus/%1s"),
			new Lookup("dictionary.com", "http://www.dictionary.com/browse/%1s?s=t"),
			new Lookup("thesaurus.com", "http://www.thesaurus.com/browse/%1s?s=t"),
			new Lookup("merriam-webster.com/dictionary/", "https://www.merriam-webster.com/dictionary/%1s"),
			new Lookup("merriam-webster.com/thesaurus/", "https://www.merriam-webster.com/thesaurus/%1s")
		};
		
		Menu mlu = new Menu("Lookup");
		
		for (int i=0; i<lookups.length; ++i)
		{
			Lookup lu = lookups[i];
			if (lu == null)
			{
				mlu.getItems().add(new SeparatorMenuItem());
				continue;
			}
			
			MenuItem mlui = new MenuItem(lu.name);
			mlui.setOnAction(actionEvent ->
			{
				if (current_entry != null)
				{
					String url = String.format(lu.pattern, current_entry.word);
					try
					{
						Utility.openWebpage(url);
					}
					catch (Exception ex)
					{
						Alert alert = new Alert(AlertType.ERROR, "Error Opening Webpage: "+ex.getMessage());
						alert.setHeaderText(null);
						alert.showAndWait();
					}
				}
			});
			mlu.getItems().add(mlui);
		}
		
		
		
		
		Menu mdb = new Menu("Database");
		MenuItem mdb_new = new MenuItem("New Database");
		mdb_new.setOnAction(actionEvent -> {
			createDatabase();
		});
		MenuItem mdb_open = new MenuItem("Open Database");
		mdb_open.setOnAction(actionEvent -> {
			openDatabase();
		});
		
		Menu mdb_export = new Menu("Export");
		MenuItem mdb_export_html = new MenuItem("to HTML");
		mdb_export_html.setOnAction(actionEvent -> {
			if (lexicon != null)
			{
				FileChooser file_chooser = new FileChooser();
				file_chooser.setTitle("Save HTML Export");
				FileChooser.ExtensionFilter file_filter = new FileChooser.ExtensionFilter("HTML files (*.html)", "*.html");
				file_chooser.getExtensionFilters().add(file_filter);
				file_chooser.setInitialFileName("export"+Utility.dateAsFileName()+".html");
				File file = file_chooser.showSaveDialog(primary_stage);
				if (file != null)
				{
					try
					{
						lexicon.exportToHTML(file.getAbsolutePath());
					}
					catch (Exception ex)
					{
						Alert alert = new Alert(AlertType.ERROR, "Error exporting to HTML: "+ex.getMessage());
						alert.setHeaderText(null);
						alert.showAndWait();
					}
				}
			}
		});
		MenuItem mdb_export_csv = new MenuItem("to CSV");
		mdb_export_csv.setOnAction(actionEvent -> {
			if (lexicon != null)
			{
				FileChooser file_chooser = new FileChooser();
				file_chooser.setTitle("Save CSV Export");
				FileChooser.ExtensionFilter file_filter = new FileChooser.ExtensionFilter("CSV files (*.csv)", "*.csv");
				file_chooser.getExtensionFilters().add(file_filter);
				file_chooser.setInitialFileName("export"+Utility.dateAsFileName()+".csv");
				File file = file_chooser.showSaveDialog(primary_stage);
				if (file != null)
				{
					try
					{
						lexicon.exportToCSV(file.getAbsolutePath());
					}
					catch (Exception ex)
					{
						Alert alert = new Alert(AlertType.ERROR, "Error exporting to HTML: "+ex.getMessage());
						alert.setHeaderText(null);
						alert.showAndWait();
					}
				}
			}
		});
		MenuItem mdb_export_txt = new MenuItem("to TXT");
		mdb_export_txt.setOnAction(actionEvent -> {
			if (lexicon != null)
			{
				FileChooser file_chooser = new FileChooser();
				file_chooser.setTitle("Save TXT Export");
				FileChooser.ExtensionFilter file_filter = new FileChooser.ExtensionFilter("TXT files (*.txt)", "*.txt");
				file_chooser.getExtensionFilters().add(file_filter);
				file_chooser.setInitialFileName("export"+Utility.dateAsFileName()+".txt");
				File file = file_chooser.showSaveDialog(primary_stage);
				if (file != null)
				{
					try
					{
						lexicon.exportToTXT(file.getAbsolutePath());
					}
					catch (Exception ex)
					{
						Alert alert = new Alert(AlertType.ERROR, "Error exporting to HTML: "+ex.getMessage());
						alert.setHeaderText(null);
						alert.showAndWait();
					}
				}
			}
		});
		mdb_export.getItems().addAll(mdb_export_html, mdb_export_csv, mdb_export_txt);
		mdb.getItems().addAll(mdb_new, mdb_open, mdb_export);
		
		menu_bar.getMenus().addAll(mw, mlu, mdb);
		return menu_bar;
	}
	
	
	public void refreshEntryView()
	{
		if (current_entry == null)
		{
			label_word.setText("");
			label_description.setText("");
			ass_view.getItems().clear();
			tag_view.getItems().clear();
		}
		else
		{
			label_word.setText(current_entry.word);
			label_description.setText(current_entry.description);
			ass_view.setItems(WordEntry.toList(current_entry.associations));
			tag_view.setItems(WordEntry.toList(current_entry.tags));
		}
	}
	
	public void refreshEntryEdit()
	{
		if (current_entry == null)
		{
			input_word.setText("");
			input_description.setText("");
			ass_edit.getItems().clear();
			tag_edit.getItems().clear();
		}
		else
		{
			input_word.setText(current_entry.word);
			input_description.setText(current_entry.description);
			ass_edit.setItems(WordEntry.toList(current_entry.associations));
			tag_edit.setItems(WordEntry.toList(current_entry.tags));
		}
	}
	
	
	public String promptInput(String prompt)
	{
		Dialog dialog = new TextInputDialog();
		dialog.setHeaderText(prompt);
		Optional<String> o = dialog.showAndWait();
		if (o.isPresent())
		{
			return o.get();
		}
		return null;
	}
	
	
	
	
	private BorderPane buildListView()
	{
		list_view = new ListView<WordEntry>();
		list_view.getSelectionModel().selectedItemProperty().addListener((ObservableValue<? extends WordEntry> observable, WordEntry oldValue, WordEntry selected_entry) ->
		{
			if (isEditing())
			{
				Alert alert = new Alert(AlertType.CONFIRMATION, "Would you like to cancel the changes you made?");
				alert.setHeaderText(null);
				Optional<ButtonType> result = alert.showAndWait();
				if (result.get() == ButtonType.CANCEL)
				{
					return;
				}
				else
				{
					split_pane.getItems().set(1, pane_view_entry);
				}
			}
			
			if (selected_entry == null)
			{
				return;
			}
			
			current_entry = selected_entry;
			refreshEntryView();
		});
		FilteredList<WordEntry> filtered_words = new FilteredList<WordEntry>(words, s -> true);
		list_view.setItems(filtered_words);
		
		filter_input = new TextField();
		filter_input.setPromptText("filter");
		filter_input.textProperty().addListener(obs->{
			
			if (timeline != null) timeline.stop();
			timeline = new Timeline(new KeyFrame(Duration.millis(250), ae->
			{
				String filter = filter_input.getText(); 
				if (filter == null || filter.length() == 0)
				{
					filtered_words.setPredicate(s -> true);
				}
				else if (filter.startsWith("word:"))
				{
					filtered_words.setPredicate(s -> s.word.contains(filter.substring("word:".length())));
				}
				else if (filter.startsWith("description:"))
				{
					filtered_words.setPredicate(s -> s.word.contains(filter.substring("description:".length())));
				}
				else if (filter.startsWith("association:"))
				{
					filtered_words.setPredicate(s -> s.word.contains(filter.substring("association:".length())));
				}
				else if (filter.startsWith("tag:"))
				{
					filtered_words.setPredicate(s -> s.word.contains(filter.substring("tag:".length())));
				}
				else
				{
					filtered_words.setPredicate(s->s.word.contains(filter));
				}
			}));
			timeline.play();
		});
		
		BorderPane left_pane = new BorderPane();
		left_pane.setCenter(list_view);
		left_pane.setTop(filter_input);
		SplitPane.setResizableWithParent(left_pane, Boolean.FALSE);
		
		return left_pane;
	}
	
	private void buildViewPane()
	{
		Image img_edit = new Image(getClass().getClassLoader().getResourceAsStream("icons/edit.png"));
		Button btn_edit = new Button();
		btn_edit.setGraphic(new ImageView(img_edit));
		btn_edit.setOnAction((ActionEvent event) ->
		{
			if (current_entry != null)
			{
				refreshEntryEdit();
				split_pane.getItems().set(1, pane_edit_entry);
				input_word.requestFocus();
			}
		});
		
		pane_view_entry = new BorderPane();
		label_word = new Label();
		label_word.setFont(new Font("Open Sans", 27));
		Pane center_spacer_view = new Pane();
		HBox.setHgrow(center_spacer_view, Priority.ALWAYS);
		HBox view_header = new HBox(0);
		view_header.setPadding(new Insets(10));
		view_header.getChildren().addAll(label_word, center_spacer_view, btn_edit);
		
		label_description = new Label();
		label_description.setWrapText(true);
		label_description.setContentDisplay(ContentDisplay.TOP);
		label_description.setAlignment(Pos.TOP_LEFT);
		
		VBox pane_description = new VBox();
		pane_description.setPadding(new Insets(10));
		pane_description.getChildren().add(label_description);
		
		ass_view = new ListView<String>();
		ass_view.setOrientation(Orientation.HORIZONTAL);
		ass_view.getSelectionModel().selectedItemProperty().addListener((ObservableValue<? extends String> observable, String oldValue, String selected_word) ->
		{
			// this HAS to be done on a separate thread
			// because the ass_view is changing its own items
			// BEFORE method body terminates
			// otherwise you'll get an IndexOutOfBounds exception
			Platform.runLater(() ->
			{
				if (selected_word != null)
				{
					int index = findIndex(selected_word);
					if (index >= 0)
					{
						list_view.getSelectionModel().select(index);
					}
				}
			});

		});
		
		tag_view = new ListView<String>();
		tag_view.setOrientation(Orientation.HORIZONTAL);
		tag_view.getSelectionModel().selectedItemProperty().addListener((ObservableValue<? extends String> observable, String oldValue, String selected_tag) ->
		{
			filter_input.setText("tag:"+selected_tag);
		});
		
		VBox ass_tag_box = new VBox();
		ass_tag_box.getChildren().addAll(ass_view, tag_view);
		ass_tag_box.setMaxHeight(50.0);
		
		pane_view_entry.setTop(view_header);
		pane_view_entry.setCenter(pane_description);
		pane_view_entry.setBottom(ass_tag_box);
	}
	
	private void buildEditPane()
	{
		pane_edit_entry = new BorderPane();
		
		Image img_save = new Image(getClass().getClassLoader().getResourceAsStream("icons/save.png"));
		Button btn_save = new Button();
		btn_save.setGraphic(new ImageView(img_save));
		btn_save.setOnAction((ActionEvent event) ->
		{
			if (current_entry == null) // creating a new entry
			{
				String word = input_word.getText();
				if (hasWord(word))
				{
					Alert alert = new Alert(AlertType.WARNING, "That word already exists!");
					alert.setHeaderText(null);
					alert.showAndWait();
				}
				else
				{
					current_entry = new WordEntry(input_word.getText(),
													input_description.getText(),
													WordEntry.toString(ass_edit.getItems()),
													WordEntry.toString(tag_edit.getItems()));
					try
					{
						lexicon.createEntry(current_entry);
						int index = findInsertionIndex(current_entry.word);
						words.add(index, current_entry);
						split_pane.getItems().set(1, pane_view_entry);
						list_view.getSelectionModel().select(index);
					}
					catch (SQLException ex)
					{
						Alert alert = new Alert(AlertType.ERROR, "Error Saving to Database: "+ex.getMessage());
						alert.setHeaderText(null);
						alert.showAndWait();
					}
				}
			}
			else // editing an existing entry
			{
				String old_word = current_entry.word;
				current_entry = new WordEntry(input_word.getText(),
												input_description.getText(),
												WordEntry.toString(ass_edit.getItems()),
												WordEntry.toString(tag_edit.getItems()));
				try
				{
					lexicon.editEntry(old_word, current_entry);
					if (!old_word.equals(current_entry.word))
					{
						int old_index = findIndex(old_word);
						words.remove(old_index);
						int index = findInsertionIndex(current_entry.word);
						words.add(index, current_entry);
						list_view.getSelectionModel().select(index);
					}
					else
					{
						// the current word is already selected, just refresh the view
						refreshEntryView();
						split_pane.getItems().set(1, pane_view_entry);
					}
					
				}
				catch (SQLException ex)
				{
					Alert alert = new Alert(AlertType.ERROR, "Error Saving to Database: "+ex.getMessage());
					alert.setHeaderText(null);
					alert.showAndWait();
				}
			}
		});
		
		Image img_cancel = new Image(getClass().getClassLoader().getResourceAsStream("icons/x.png"));
		Button btn_cancel = new Button();
		btn_cancel.setGraphic(new ImageView(img_cancel));
		btn_cancel.setOnAction((ActionEvent event) ->
		{
			split_pane.getItems().set(1, pane_view_entry);
		});
		
		input_word = new TextField();
		input_word.setPromptText("word");
		input_word.setFont(new Font("Open Sans", 27));
		HBox.setHgrow(input_word, Priority.ALWAYS);
		HBox edit_header = new HBox(10);
		edit_header.setPadding(new Insets(10));
		edit_header.getChildren().addAll(input_word, btn_save, btn_cancel);
		
		input_description = new TextArea();
		input_description.setPromptText("description / definition");
		input_description.setWrapText(true);
		
		
		Image img_plus = new Image(getClass().getClassLoader().getResourceAsStream("icons/plus.png"));
		Image img_minus = new Image(getClass().getClassLoader().getResourceAsStream("icons/minus.png"));
		
		
		ass_edit = new ListView();
		ass_edit.setOrientation(Orientation.HORIZONTAL);
		ass_edit.getSelectionModel().setSelectionMode(SelectionMode.MULTIPLE);
		Button ass_bt_add = new Button();
		ass_bt_add.setGraphic(new ImageView(img_plus));
		ass_bt_add.setOnAction((ActionEvent event) ->
		{
			String input = promptInput("Enter word to create association:");
			if (input != null)
			{
				ass_edit.getItems().add(input);
			}
		});
		Button ass_bt_delete = new Button();
		ass_bt_delete.setGraphic(new ImageView(img_minus));
		ass_bt_delete.setOnAction((ActionEvent event) ->
		{
			ass_edit.getItems().removeAll(ass_edit.getSelectionModel().getSelectedItems());
		});
		VBox ass_bts = new VBox();
		ass_bts.getChildren().addAll(ass_bt_add, ass_bt_delete);
		BorderPane ass_box = new BorderPane();
		ass_box.setCenter(ass_edit);
		ass_box.setRight(ass_bts);
		
		tag_edit = new ListView();
		tag_edit.setOrientation(Orientation.HORIZONTAL);
		Button tag_bt_add = new Button();
		tag_bt_add.setGraphic(new ImageView(img_plus));
		tag_bt_add.setOnAction((ActionEvent event) ->
		{
			String input = promptInput("Enter tag:");
			if (input != null)
			{
				tag_edit.getItems().add(input);
			}
		});
		Button tag_bt_delete = new Button();
		tag_bt_delete.setGraphic(new ImageView(img_minus));
		tag_bt_delete.setOnAction((ActionEvent event) ->
		{
			tag_edit.getItems().removeAll(tag_edit.getSelectionModel().getSelectedItems());
		});
		VBox tag_bts = new VBox();
		tag_bts.getChildren().addAll(tag_bt_add, tag_bt_delete);
		BorderPane tag_box = new BorderPane();
		tag_box.setCenter(tag_edit);
		tag_box.setRight(tag_bts);
		
		
		VBox ass_tags_box = new VBox();
		ass_tags_box.getChildren().addAll(ass_box, tag_box);
		ass_tags_box.setMaxHeight(30.0);
		
		pane_edit_entry.setTop(edit_header);
		pane_edit_entry.setCenter(input_description);
		pane_edit_entry.setBottom(ass_tags_box);
	}
	
	private void buildGUI()
	{
		buildIntroPane();
		MenuBar menu_bar = buildMenuBar();
		BorderPane left_pane = buildListView();
		buildViewPane();
		buildEditPane();
		
		split_pane = new SplitPane();
		split_pane.getItems().addAll(left_pane, pane_view_entry);
		
		pane_main = new BorderPane();
		pane_main.setTop(menu_bar);
		pane_main.setCenter(split_pane);
	}
	
	private void loadWords()
	{
		try
		{
			lexicon.loadWords(words);
			if (!ProgramProperties.last_word.equals(""))
			{
				int index = findIndex(ProgramProperties.last_word);
				list_view.getSelectionModel().select(index);
			}
			else
			{
				list_view.getSelectionModel().selectFirst();
			}
		}
		catch (SQLException ex)
		{
			lexicon = null;
			Alert alert = new Alert(AlertType.ERROR, "Error Opening Database, path: "+ProgramProperties.database_path+", error: "+ex.getMessage());
			alert.setHeaderText(null);
			alert.showAndWait();
		}
	}
	
	public void start(Stage primary_stage)
	{
		this.primary_stage = primary_stage;
		words = FXCollections.observableArrayList();
		
		buildGUI();
		loadProperties();
		
		if (!ProgramProperties.database_path.equals(""))
		{
			if (Utility.fileExists(ProgramProperties.database_path))
			{
				lexicon = new Database(ProgramProperties.database_path);
				loadWords();
			}
			else
			{
				Alert alert = new Alert(AlertType.ERROR, "Database file not found: "+ProgramProperties.database_path);
				alert.setHeaderText(null);
				alert.showAndWait();
			}
		}
		
		// either the database path was never set, or loading it failed
		if (lexicon == null)
		{
			scene = new Scene(pane_load_lexicon);
		}
		else
		{
			scene = new Scene(pane_main);
		}
		
        primary_stage.setOnCloseRequest((WindowEvent we) ->
		{
			saveProperties();
		});
		
		primary_stage.setTitle("Boniface v0.9");
		primary_stage.setScene(scene);
		primary_stage.show();
	}
	
	public static void main(String[] args)
	{
		launch(args);
	}
}
