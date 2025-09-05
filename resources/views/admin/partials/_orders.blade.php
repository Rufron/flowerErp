<h3 class="mt-8 mb-4 text-xl font-semibold text-gray-800 flex items-center gap-2">
  📦 Orders Overview
</h3>

<div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full border-collapse text-left text-gray-700">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">#</th>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">Customer</th>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">Flower</th>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">Status</th>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4">101</td>
          <td class="px-6 py-4">Alice</td>
          <td class="px-6 py-4">Roses</td>
          <td class="px-6 py-4">
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
              Pending
            </span>
          </td>
          <td class="px-6 py-4 space-x-2">
            <button class="px-3 py-1 rounded-lg bg-green-100 text-green-700 hover:bg-green-200 text-sm font-medium">
              Approve
            </button>
            <button class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 text-sm font-medium">
              Ship
            </button>
            <button class="px-3 py-1 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 text-sm font-medium">
              Cancel
            </button>
          </td>
        </tr>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4">102</td>
          <td class="px-6 py-4">Brian</td>
          <td class="px-6 py-4">Lilies</td>
          <td class="px-6 py-4">
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
              Processing
            </span>
          </td>
          <td class="px-6 py-4 space-x-2">
            <button class="px-3 py-1 rounded-lg bg-green-100 text-green-700 hover:bg-green-200 text-sm font-medium">
              Approve
            </button>
            <button class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 text-sm font-medium">
              Ship
            </button>
            <button class="px-3 py-1 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 text-sm font-medium">
              Cancel
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
