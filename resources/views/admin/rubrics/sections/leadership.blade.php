<div class="rubric-section">
    <h4 class="rubric-heading">I. Leadership Excellence</h4>

    <!-- Section A: Campus Based -->
    <div class="subsection mb-4">
        <h5 class="subsection-title">A. Campus Based</h5>
        <div class="table-wrap">
            <table class="manage-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Position / Title</th>
                        <th>Points</th>
                        <th>Max Points</th>
                        <th>Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Student Government</td>
                        <td>President</td>
                        <td>5.0</td>
                        <td>5</td>
                        <td>Certificate of Election</td>
                        <td>
                            <button class="btn btn-disable">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Campus Student Council</td>
                        <td>Vice President</td>
                        <td>4.0</td>
                        <td>5</td>
                        <td>Oath of Office</td>
                        <td>
                            <button class="btn btn-disable">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Local Councils</td>
                        <td>Secretary</td>
                        <td>3.0</td>
                        <td>5</td>
                        <td>Appointment Letter</td>
                        <td>
                            <button class="btn btn-disable">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Student Clubs and Organizations</td>
                        <td>President</td>
                        <td>3.0</td>
                        <td>5</td>
                        <td>Certificate of Election</td>
                        <td>
                            <button class="btn btn-disable">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section B: Designation in Special Orders/Office Orders -->
    <div class="subsection mb-4">
        <h5 class="subsection-title">B. Designation in Special Orders/Office Orders</h5>
        <div class="table-wrap">
            <table class="manage-table">
                <thead>
                    <tr>
                        <th>Order Type</th>
                        <th>Position / Title</th>
                        <th>Points</th>
                        <th>Max Points</th>
                        <th>Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Special Order</td>
                        <td>Committee Chair</td>
                        <td>4.0</td>
                        <td>5</td>
                        <td>Special Order Document</td>
                        <td>
                            <button class="btn btn-disable">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section C: Community Based -->
    <div class="subsection mb-4">
        <h5 class="subsection-title">C. Community Based</h5>
        <div class="table-wrap">
            <table class="manage-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Position / Title</th>
                        <th>Points</th>
                        <th>Max Points</th>
                        <th>Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Local Government Unit</td>
                        <td>Barangay Kagawad</td>
                        <td>5.0</td>
                        <td>5</td>
                        <td>Certificate of Election</td>
                        <td>
                            <button class="btn btn-disable">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Elective/Appointive Position</td>
                        <td>Youth Council Member</td>
                        <td>4.0</td>
                        <td>5</td>
                        <td>Appointment Letter</td>
                        <td>
                            <button class="btn btn-disable">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section D: Leadership Training/Seminars/Conferences -->
    <div class="subsection mb-4">
        <h5 class="subsection-title">D. Leadership Training/Seminars/Conferences Attended (max 5 points)</h5>
        <div class="table-wrap">
            <table class="manage-table">
                <thead>
                    <tr>
                        <th>Training/Seminar/Conference</th>
                        <th>Role</th>
                        <th>Points</th>
                        <th>Max Points</th>
                        <th>Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Leadership Development Program</td>
                        <td>Participant</td>
                        <td>2.0</td>
                        <td>5</td>
                        <td>Certificate of Participation</td>
                        <td>
                            <button class="btn btn-disable">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Student Leadership Conference</td>
                        <td>Delegate</td>
                        <td>3.0</td>
                        <td>5</td>
                        <td>Certificate of Attendance</td>
                        <td>
                            <button class="btn btn-disable">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <h5>Add New Leadership Item</h5>
        <form>
            <div class="form-row">
                <select class="form-control">
                    <option value="">Select Subsection</option>
                    <option value="campus_based">A. Campus Based</option>
                    <option value="special_orders">B. Special Orders/Office Orders</option>
                    <option value="community_based">C. Community Based</option>
                    <option value="training">D. Leadership Training/Seminars/Conferences</option>
                </select>
                <input type="text" placeholder="Category/Type" class="form-control">
                <input type="text" placeholder="Position / Title" class="form-control">
                <input type="number" placeholder="Points" class="form-control" step="0.1" min="0" max="5">
                <input type="text" placeholder="Evidence" class="form-control">
                <button class="btn btn-disable" type="button">Add</button>
            </div>
        </form>
    </div>
</div>
