<?php
if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    function top()
    {
        return  '<div id="top">
                <fieldset>
                    <form action="" method="post">
                        <button type="submit" id="findStudent" name="findStudent" class="btn2">Find Particular Student</button>
                        <button type="submit" name="allStudents" class="btn2">All Students</button>
                        <button type="submit" name="addStudent" class="btn2">Add Student</button>
                        <button type="submit" name="deleteStudent" class="btn2">Delete Student</button>
                        <button type="submit" name="editStudent" class="btn2">Edit Student Details</button>
                        <button type="submit" name="viewAttendance" class="btn2">Attendance</button>
                        <button type="submit" name="feesRelated" class="btn2">Fees Records</button>
                        <button type="submit" name="reportsRelated" class="btn2">Reports</button>
                    </form>
                </fieldset>
            </div>';
    }
}
