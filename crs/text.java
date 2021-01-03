import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.Scanner;
public class Sem2OOP_DB {
 Connection myConn;
 Statement myStat;
 ResultSet myRs;
 PreparedStatement preStat;

 public static void main(String[] args) {
 Sem2OOP_DB obj = new Sem2OOP_DB();
 obj.setConnection("root","");
 obj.retriveData();

 }

 public void setConnection(String userName, String pswd){
 try{
 myConn = DriverManager.getConnection("jdbc:mysql://localhost:3306/sem2oop",userName, pswd);
 myStat = myConn.createStatement();
 System.out.println("Connected");

 }catch(Exception e){
 e.printStackTrace();
 }

 }

 public void retriveData(){
 try{
 myRs = myStat.executeQuery("SELECT * FROM person");

 while(myRs.next()){
 System.out.println("\nName : " + myRs.getString("Name"));
 System.out.println("Sex : " + myRs.getString(2));
 System.out.println("Age : " + myRs.getString("Age"));
 }

 }catch(Exception e){
 e.printStackTrace();
 }
 }

 public void insertData(){//Update & Delete same code, just change SQL
 String insert= "INSERT INTO person VALUE('jOHN', 'm', 78)";

 try{
 int i = myStat.executeUpdate(insert);
 if (i > 0)
 System.out.println("Insert Success");
 else
 System.out.println("Insert Fail");

 }catch(Exception e){
 e.printStackTrace();
 }
 }

 public void insertDataKeybord(){

 Scanner masuk = new Scanner(System.in);


 System.out.println("Insert Age : "); int age = masuk.nextInt();
 System.out.println("Insert Name : "); String name = masuk.next();
 System.out.println("Insert Gender : "); String gender = masuk.next();

 try{
 preStat = myConn.prepareStatement("INSERT INTO person VALUE(?,?,?)");
 preStat.setString(1, name);
 preStat.setString(2, gender);
 preStat.setInt(3, age);
 preStat.executeUpdate();

 }catch(Exception e){
 e.printStackTrace();
 }
 }
 public void insertUpdateDeleteMethod(){//Insert, Update & Delete Using Same Code, Just Change The SQL
Statement

 String update = "UPDATE person SET Age = 55, Sex = 'M' WHERE Name = 'Test'";
 String delete = "DELETE FROM person WHERE Name = 'Test'";
 String insert = "INSERT INTO person VALUE('jOHN', 'm', 78)";

 try{
 int i = myStat.executeUpdate(delete);
 if (i > 0)
 System.out.println("Insert/Update/Delete Success");
 else
 System.out.println("Insert/Update/Delete Fail");

 }catch(Exception e){
 e.printStackTrace();
 }
 }

}